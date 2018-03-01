<?php

namespace ST\UserBundle\Controller;

use ST\UserBundle\Form\UserType;
use ST\UserBundle\Form\UserForgotPasswordType;
use ST\UserBundle\Form\UserResetPasswordType;
use ST\UserBundle\Entity\User;
use ST\UserBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('tricks_home');
        }

        // Le service authentication_utils permet de récupérer le nom d'utilisateur
        // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
        // (mauvais mot de passe par exemple)
        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('UserBundle:Security:login.html.twig', array(
          'last_username' => $authenticationUtils->getLastUsername(),
          'error'         => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

    public function registerAction(Request $request)
    {
        $passwordEncoder = $this->get('security.password_encoder');
        // 1) build the form
        $user = new User();
        $form = $this->get('form.factory')->create(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $user->setConfirmationToken(md5(time()*rand(357, 412)));

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
          
            $message = (new \Swift_Message('Validation compte SnowTricks'))
                ->setFrom('send@example.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'UserBundle:Security:registerValidation.html.twig',
                        array('name' => $user->getUsername(),
                        'token' => $user->getConfirmationToken())
                    ),
                    'text/html'
                );

            $this->get('mailer')->send($message);
            // or, you can also fetch the mailer service this way
            // $this->get('mailer')->send($message);

            $this->addFlash('warning', 'Un mail de confirmation vient de vous être envoyé, merci de cliquer sur le lien joint.');
            return $this->redirectToRoute('tricks_home');
        }

        return $this->render(
            'UserBundle:Security:register.html.twig',
            array('form' => $form->createView())
        );
    }

    public function checkAction($token)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('UserBundle:User');

        if ($user = $repository->findOneBy(array('confirmationToken' => $token))) {
            $user->setConfirmationToken(null);
            $user->setIsActive(true);
            $em->flush();
            $this->addFlash('notice', 'Bienvenue '. $user->getUsername(). ' ! Votre compte est maintenant activé, vous pouvez vous connecter !');
        } else {
            $this->addFlash('error', 'Le lien sur lequel vous avez cliqué semble corrumpu.');
        }
        return $this->redirectToRoute('tricks_home');
    }

    public function forgotPasswordAction(Request $request)
    {
        $form = $this->get('form.factory')->create(UserForgotPasswordType::class);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('UserBundle:User');
            $user = $form->getData();

            if ($user = $repository->findOneBy(array('email' => $user->getEmail()))) {
                $user->setConfirmationToken(md5(time()*rand(357, 412)));
                $em->flush();

                $message = (new \Swift_Message('Changement mot de passe compte SnowTricks'))
                ->setFrom('send@example.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'UserBundle:Security:forgotPasswordValidation.html.twig',
                        array('name' => $user->getUsername(),
                        'token' => $user->getConfirmationToken())
                    ),
                    'text/html'
                );

                $this->get('mailer')->send($message);
                $this->addFlash('warning', 'Un mail de confirmation vient de vous être envoyé, merci de cliquer sur le lien joint.');
            } else {
                $this->addFlash('error', 'Mail invalide');
                return $this->redirectToRoute('forgot_password');
            }
            return $this->redirectToRoute('tricks_home');
        }
        return $this->render(
            'UserBundle:Security:forgotPassword.html.twig',
            array('form' => $form->createView())
        );
    }

    public function resetPasswordAction(Request $request, $token)
    {
        $passwordEncoder = $this->get('security.password_encoder');

        $em = $this->getDoctrine()->getManager();

        $repository = $em
            ->getRepository('UserBundle:User');
        ;
        ;

        if ($user=$repository->findOneBy(array('confirmationToken' => $token))) {
            $form = $this->get('form.factory')->create(UserResetPasswordType::class, $user);

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

                // Inutile de persister ici, Doctrine connait déjà notre user
               
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $user->setConfirmationToken(null);
                $em->flush();
                $this->addFlash('notice', 'Bienvenue '. $user->getUsername(). ' ! Votre compte est à nouveau activé, vous pouvez vous connecter !');
                return $this->redirectToRoute('tricks_home');
            }
        }
          
        return $this->render(
            'UserBundle:Security:resetPassword.html.twig',
          
             array(
            'user' => $user,
            'form' => $form->createView(),
        )
          
         );
    }
}

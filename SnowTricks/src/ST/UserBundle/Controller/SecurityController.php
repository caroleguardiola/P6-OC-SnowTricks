<?php

namespace ST\UserBundle\Controller;

use ST\UserBundle\Form\UserType;
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

            $user->setConfirmationToken(md5(time()*rand(357,412)));

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
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'Emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;

        $this->get('mailer')->send($message);
        // or, you can also fetch the mailer service this way
        // $this->get('mailer')->send($message);


            return $this->redirectToRoute('login');
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
        if ($user = $repository->findOneBy(array('confirmationToken' =>$token))){
            $user->setConfirmationToken(NULL);
            $user->setIsActive(true);            
            $em->flush();
            $this->addFlash('success', 'Bienvenue à vous '. $user->getUsername().' Votre compte est maintenant activé, vous pouvez vous connecter.');
        } else {
            $this->addFlash('danger', 'Le lien sur lequel vous avez cliqué semble corrumpu.');
        }
        return $this->redirectToRoute('login');
    }
}

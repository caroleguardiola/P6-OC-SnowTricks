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

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('login');
        }

        return $this->render(
            'UserBundle:Security:register.html.twig',
            array('form' => $form->createView())
        );
    }
}

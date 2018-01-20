<?php

namespace TricksBundle\Controller;

use TricksBundle\Entity\Trick;
use TricksBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrickController extends Controller
{
    public function indexAction()
    {
         $content = $this->render('TricksBundle:Trick:index.html.twig', array('listTricks' => array()));
    
    return new Response($content);
    }

    public function viewAction($id)
    {
    	  $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $trick = $em->getRepository('TricksBundle:Trick')->find($id);

    if (null === $trick) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // On récupère la liste des candidatures de cette annonce
    $listImages = $em
      ->getRepository('TricksBundle:Image')
      ->findBy(array('trick' => $trick))
    ;

    
    return $this->render('TricksBundle:Trick:view.html.twig',array(
        'trick'           => $trick,
        'listImages' => $listImages
      ));
    }

    public function addAction(Request $request)
	{
	    // Création de l'entité Advert
    $trick = new Trick();
    $trick->setName('Recherche développeur Symfony.');
    $trick->setDescription("Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…");

    // Création de l'entité Image
    $image = new Image();
    $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
    $image->setAlt('Job de rêve');

    // On lie l'image à l'annonce
    $image->setTrick($trick);

    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // Étape 1 : On « persiste » l'entité
    $em->persist($trick);

    // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
    // on devrait persister à la main l'entité $image
    // $em->persist($image);

    // Étape 1 ter : pour cette relation pas de cascade lorsqu'on persiste Advert, car la relation est
    // définie dans l'entité Application et non Advert. On doit donc tout persister à la main ici.
    $em->persist($image);

    // Étape 2 : On déclenche l'enregistrement
    $em->flush();

      if ($request->isMethod('POST')) {
	      $request->getSession()->getFlashBag()->add('notice', 'Trick bien enregistré.');	     
	      return $this->redirectToRoute('tricks_homepage');
	    }
	    
	    return $this->render('TricksBundle:Trick:add.html.twig');
	}

    public function editAction($id, Request $request)
    {
        if ($request->isMethod('POST')) {
          $request->getSession()->getFlashBag()->add('notice', 'Trick bien modifié.');
          return $this->redirectToRoute('tricks_homepage');
        }
        
        return $this->render('TricksBundle:Trick:edit.html.twig', array(
          'trick' => array()
        ));
    }
}

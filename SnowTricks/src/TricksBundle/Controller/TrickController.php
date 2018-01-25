<?php

namespace TricksBundle\Controller;

use TricksBundle\Entity\Trick;
use TricksBundle\Entity\Image;
use TricksBundle\Entity\Video;
use TricksBundle\Entity\Category;
use TricksBundle\Entity\Comment;
use TricksBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrickController extends Controller
{
    public function indexAction()
    {
      $listTricks = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('TricksBundle:Trick')
        ->getTricks()
      ;

      return $this->render('TricksBundle:Trick:index.html.twig', array(
        'listTricks' => $listTricks,
      ));
    }

    public function viewAction($id)
    {
  	   $trick = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('TricksBundle:Trick')
        ->getTrickDetails($id);

      if (null === $trick) {
        throw new NotFoundHttpException("Le trick d'id ".$id." n'existe pas.");
      }
    
      return $this->render('TricksBundle:Trick:view.html.twig',array(
          'trick' => $trick,
      ));
    }

    public function addAction(Request $request)
  	{
      $em = $this->getDoctrine()->getManager();
      // On ne sait toujours pas gérer le formulaire, patience cela vient dans la prochaine partie !

      if ($request->isMethod('POST')) {
	      $request->getSession()->getFlashBag()->add('notice', 'Trick bien enregistré.');	     
	      return $this->redirectToRoute('tricks_homepage', array('id' => $trick->getId()));
  	    }
  	    
  	    return $this->render('TricksBundle:Trick:add.html.twig');
  	}

    public function editAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      // On récupère le trick $id
      $trick = $em->getRepository('TricksBundle:Trick')->find($id);
      if (null === $trick) {
        throw new NotFoundHttpException("Le trick d'id ".$id." n'existe pas.");
      }
      
      // Ici encore, il faudra mettre la gestion du formulaire 

      if ($request->isMethod('POST')) {
        $request->getSession()->getFlashBag()->add('notice', 'Trick bien modifié.');
        return $this->redirectToRoute('tricks_homepage', array('id' => $trick->getId()));
      }
      
      return $this->render('TricksBundle:Trick:edit.html.twig', array(
        'trick' => $trick
      ));
    }
}

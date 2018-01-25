<?php

namespace TricksBundle\Controller;

use TricksBundle\Entity\Trick;
use TricksBundle\Entity\Image;
use TricksBundle\Entity\Video;
use TricksBundle\Entity\Category;
use TricksBundle\Entity\Comment;
use TricksBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
      $trick = new Trick();

      $trick->setDateCreation(new \Datetime());

      $form = $this->get('form.factory')->createBuilder(FormType::class, $trick)
        ->add('dateCreation', DateType::class)
        ->add('name',         TextType::class)
        ->add('description',  TextareaType::class)
        ->add('save',         SubmitType::class)
        ->getForm();

      if ($request->isMethod('POST')) {
         $form->handleRequest($request);
      
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($trick);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Trick bien enregistré.');	     
	      return $this->redirectToRoute('tricks_homepage', array('id' => $trick->getId()));
  	    }
      }
  	    
      return $this->render('TricksBundle:Trick:add.html.twig', array(
        'form' => $form->createView(),
        ));
  	}

    public function editAction($id, Request $request)
    {
      $trick = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('TricksBundle:Trick')
        ->find($id)
      ;

      $form = $this->get('form.factory')->createBuilder(FormType::class, $trick)
        ->add('dateCreation', DateType::class)
        ->add('name',         TextType::class)
        ->add('description',  TextareaType::class)
        ->add('save',         SubmitType::class)
        ->getForm();

      if ($request->isMethod('POST')) {
         $form->handleRequest($request);
      
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($trick);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Trick bien modifié.');      
        return $this->redirectToRoute('tricks_homepage', array('id' => $trick->getId()
        ));
        }
      }
      
      return $this->render('TricksBundle:Trick:add.html.twig', array(
        'form' => $form->createView(),
        ));
    }
}

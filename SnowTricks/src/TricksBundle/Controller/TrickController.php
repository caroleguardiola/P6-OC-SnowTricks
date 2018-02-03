<?php

namespace TricksBundle\Controller;

use TricksBundle\Entity\Trick;
use TricksBundle\Entity\Image;
use TricksBundle\Entity\Video;
use TricksBundle\Entity\Category;
use TricksBundle\Entity\Comment;
use TricksBundle\Entity\User;
use TricksBundle\Form\TrickType;
use TricksBundle\Form\CommentType;
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

    public function viewAction($id, Request $request)
    {
  	  $em = $this->getDoctrine()->getManager();

      $trick = $em
        ->getRepository('TricksBundle:Trick')
        ->getTrickDetails($id);

      $listComments = $em
        ->getRepository('TricksBundle:Comment')
        ->findByTrick($id);

      if (null === $trick) {
        throw new NotFoundHttpException("Le trick d'id ".$id." n'existe pas.");
      }
    
      $comment = new Comment();

      $comment->setDateCreation(new \Datetime());
      $comment->setTrick($trick);
      //$comment->setUser($this->getUser());

      $form = $this->get('form.factory')->create(CommentType::class, $comment);

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        
        $em->persist($comment);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Commentaire bien enregistré.');

        return $this->redirectToRoute('tricks_home', array('id' => $trick->getId()));
      }
        
      return $this->render('TricksBundle:Trick:view.html.twig',array(
          'trick' => $trick,
          'listComments' => $listComments,
          'form' => $form->createView(),
      ));
    }

    public function addAction(Request $request)
  	{
      $trick = new Trick();

      $trick->setDateCreation(new \Datetime());

      $form = $this->get('form.factory')->create(TrickType::class, $trick);

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        
        $listImages = $trick->getImages();
            foreach ($listImages as $image)
            {
                $trick->addImage($image);
            }

        $listVideos = $trick->getVideos();
            foreach ($listVideos as $video)
            {
                $trick->addVideo($video);
            } 


        $em = $this->getDoctrine()->getManager();
        $em->persist($trick);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Trick bien enregistré.');

	      return $this->redirectToRoute('tricks_home', array('id' => $trick->getId()));
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

      $trick->setUpdatedAt(new \Datetime());

      $form = $this->get('form.factory')->create(TrickType::class, $trick);

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      // Inutile de persister ici, Doctrine connait déjà notre trick
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Trick bien modifié.');      
        return $this->redirectToRoute('tricks_home', array('id' => $trick->getId()
        ));
      }
      
      return $this->render('TricksBundle:Trick:edit.html.twig', array(
        'trick' => $trick,
        'form' => $form->createView(),
        ));
    }

    public function deleteAction(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();
      $trick = $em->getRepository('TricksBundle:Trick')->find($id);

      if (null === $trick) {
        throw new NotFoundHttpException("Le trick d'id ".$id." n'existe pas.");
      }

      $form = $this->get('form.factory')->create();
        

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em->remove($trick);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Le trick a bien été supprimé.");
        return $this->redirectToRoute('tricks_home');
      }

       return $this->render('TricksBundle:Trick:delete.html.twig', array(
      'trick' => $trick,
      'form'   => $form->createView(),
      ));
    }

}

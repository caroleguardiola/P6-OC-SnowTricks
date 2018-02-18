<?php

namespace ST\TricksBundle\Controller;

use ST\TricksBundle\Entity\Trick;
use ST\TricksBundle\Entity\Image;
use ST\TricksBundle\Entity\Video;
use ST\TricksBundle\Entity\Category;
use ST\UserBundle\Entity\Comment;
use ST\UserBundle\Entity\User;
use ST\TricksBundle\Form\TrickType;
use ST\UserBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TrickController extends Controller
{
    public function indexAction()
    {
      $listTricks = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('TricksBundle:Trick')
        ->findAll()
      ;

      return $this->render('TricksBundle:Trick:index.html.twig', array(
        'listTricks' => $listTricks,
      ));
    }

    public function viewAction($id, Request $request, $page)
    {
  	  
      if ($page < 1)
        {
            throw new NotFoundHttpException("La page n'existe pas");
        }

      $nbPerPage = 2;

      $em = $this->getDoctrine()->getManager();

      $trick = $em
        ->getRepository('TricksBundle:Trick')
        ->find($id);       

      $listComments = $em
        ->getRepository('UserBundle:Comment')
        ->findByTrick($id, $page, $nbPerPage);

      // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
      $nbPages = ceil(count($listComments) / $nbPerPage);

      // Si la page n'existe pas, on retourne une 404
      if ($page > $nbPages) {
        throw $this->createNotFoundException("La page ".$page." n'existe pas.");
      }

      if (null === $trick) {
        throw new NotFoundHttpException("Le trick d'id ".$id." n'existe pas.");
      }
    
      $comment = new Comment();

      $comment->setDateCreation(new \Datetime());
      $comment->setTrick($trick);

      $user = $this->getUser();

      if (null !== $user) {
          $comment->setUser($this->getUser());
      }

      $form = $this->get('form.factory')->create(CommentType::class, $comment);

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        
        $em->persist($comment);
        $em->flush();

        $this->addFlash('notice', 'Commentaire bien enregistré.');

        return $this->redirectToRoute('tricks_view', array('id' => $trick->getId()));
      }
        
      return $this->render('TricksBundle:Trick:view.html.twig',array(
          'trick' => $trick,
          'listComments' => $listComments,
          'nbPages'     => $nbPages,
          'page'        => $page,
          'form' => $form->createView(),
      ));
    }

    /**
    * @Security("has_role('ROLE_USER')")
    */

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

        $this->addFlash('notice', 'Trick bien enregistré.');

	      return $this->redirectToRoute('tricks_home', array('id' => $trick->getId()));
      }
  	    
      return $this->render('TricksBundle:Trick:add.html.twig', array(
        'form' => $form->createView(),
        ));
  	}

    public function editAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();

      $trick = $em
        ->getRepository('TricksBundle:Trick')
        ->find($id);
      ;

      $trick->setUpdatedAt(new \Datetime());

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
            
      // Inutile de persister ici, Doctrine connait déjà notre trick
        $em->flush();

        $this->addFlash('notice', 'Trick bien modifié.');      
        return $this->redirectToRoute('tricks_view', array('id' => $trick->getId()
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
        $this->addFlash('notice', "Le trick a bien été supprimé.");
        return $this->redirectToRoute('tricks_home');
      }

       return $this->render('TricksBundle:Trick:delete.html.twig', array(
      'trick' => $trick,
      'form'   => $form->createView(),
      ));
    }

}

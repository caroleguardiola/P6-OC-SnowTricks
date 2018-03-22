<?php

namespace ST\TricksBundle\Controller;

use ST\TricksBundle\Entity\Trick;
use ST\TricksBundle\Entity\Thumbnail;
use ST\TricksBundle\Entity\Image;
use ST\TricksBundle\Entity\Video;
use ST\TricksBundle\Entity\Category;
use ST\TricksBundle\Entity\Comment;
use ST\UserBundle\Entity\User;
use ST\TricksBundle\Form\Type\TrickType;
use ST\TricksBundle\Form\Type\TrickEditType;
use ST\TricksBundle\Form\Type\TrickEditMediasType;
use ST\TricksBundle\Form\Type\TrickEditThumbType;
use ST\TricksBundle\Form\Type\CommentType;
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
        if ($page < 1) {
            throw new NotFoundHttpException("La page n'existe pas");
        }

        $nbPerPage = 2;

        $em = $this->getDoctrine()->getManager();

        $trick = $em
        ->getRepository('TricksBundle:Trick')
        ->find((int)$id);

        $listComments = $em
        ->getRepository('TricksBundle:Comment')
        ->findByTrick($id, $page, $nbPerPage);

        // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
        $nbPages = ceil(count($listComments) / $nbPerPage);

        // Si la page n'existe pas, on retourne une 404
        if ($page > $nbPages && $page != 1) {
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

        $formComment = $this->get('form.factory')->create(CommentType::class, $comment);

        if ($request->isMethod('POST') && $formComment->handleRequest($request)->isValid()) {
            $em->persist($comment);
            $em->flush();

            $this->addFlash('notice', 'Commentaire bien enregistré.');

            return $this->redirectToRoute('tricks_view', array('id' => $trick->getId()));
        }
        
        return $this->render('TricksBundle:Trick:view.html.twig', array(
          'trick' => $trick,
          'listComments' => $listComments,
          'nbPages'     => $nbPages,
          'page'        => $page,
          'formComment' => $formComment->createView(),
      ));
    }

    /**
    * @Security("has_role('ROLE_USER')")
    */

    public function addAction(Request $request)
    {
        $trick = new Trick();

        $trick->setDateCreation(new \Datetime());

        $formAdd = $this->get('form.factory')->create(TrickType::class, $trick);

        if ($request->isMethod('POST')) {
            if ($formAdd->handleRequest($request)->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($trick);
                $em->flush();

                $this->addFlash('notice', 'Trick bien enregistré.');

                return $this->redirectToRoute('tricks_home', array('id' => $trick->getId()));
            } else {
                $this->addFlash('error', 'Le trick n\'a pas pu être enregistré.');
            }
        }

        return $this->render('TricksBundle:Trick:add.html.twig', array(
        'formAdd' => $formAdd->createView(),
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

        $formEdit = $this->get('form.factory')->create(TrickEditType::class, $trick);

        if ($request->isMethod('POST')) {
            if ($formEdit->handleRequest($request)->isValid()) {
            
                // Inutile de persister ici, Doctrine connait déjà notre trick
                $em->flush();

                $this->addFlash('notice', 'Trick bien modifié.');
                return $this->redirectToRoute('tricks_view', array('id' => $trick->getId()));
            } else {
                $this->addFlash('error', 'Le trick n\'a pas pu être modifié.');
            }
        }
      
        return $this->render('TricksBundle:Trick:edit.html.twig', array(
        'trick' => $trick,
        'formEdit' => $formEdit->createView(),
        ));
    }

    public function editMediasAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $trick = $em
        ->getRepository('TricksBundle:Trick')
        ->find($id);
        ;

        $trick->setUpdatedAt(new \Datetime());

        $formEditMedia = $this->get('form.factory')->create(TrickEditMediasType::class, $trick);

        if ($request->isMethod('POST')) {
            if ($formEditMedia->handleRequest($request)->isValid()) {
                        
                // Inutile de persister ici, Doctrine connait déjà notre trick
                $em->flush();

                $this->addFlash('notice', 'Médias bien modifiés.');
                return $this->redirectToRoute('tricks_edit', array('id' => $trick->getId() ));
            } else {
                $this->addFlash('error', 'Les Médias n\'ont pas pu être modifiés.');
            }
        }
      
        return $this->render('TricksBundle:Trick:edit_medias_mobile.html.twig', array(
        'trick' => $trick,
        'formEditMedia' => $formEditMedia->createView(),
        ));
    }

    public function editThumbbyTrickAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $trick = $em
        ->getRepository('TricksBundle:Trick')
        ->find($id);
        ;

        $trick->setUpdatedAt(new \Datetime());

        $formEditThumb = $this->get('form.factory')->create(TrickEditThumbType::class, $trick);

        if ($request->isMethod('POST')) {
            if ($formEditThumb->handleRequest($request)->isValid()) {
            
                // Inutile de persister ici, Doctrine connait déjà notre trick
                $em->flush();

                $this->addFlash('notice', 'Image à la une bien modifiée.');
                return $this->redirectToRoute('tricks_edit', array('id' => $trick->getId()));
            } else {
                $this->addFlash('error', 'L\'image à la une n\'a pas pu être modifiée.');
            }
        }
      
        return $this->render('TricksBundle:Trick:edit_thumb_trick.html.twig', array(
        'trick' => $trick,
        'formEditThumb' => $formEditThumb->createView(),
        ));
    }

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $trick = $em->getRepository('TricksBundle:Trick')->find($id);

        if (null === $trick) {
            throw new NotFoundHttpException("Le trick d'id ".$id." n'existe pas.");
        }

        $formDeleteTrick = $this->get('form.factory')->create();
        

        if ($request->isMethod('POST')) {
            if ($formDeleteTrick->handleRequest($request)->isValid()) {
                $em->remove($trick);
                $em->flush();
                $this->addFlash('notice', "Le trick a bien été supprimé.");
                return $this->redirectToRoute('tricks_home');
            } else {
                $this->addFlash('error', 'Le trick  n\'a pas pu être supprimé.');
            }
        }

        return $this->render('TricksBundle:Trick:delete.html.twig', array(
      'trick' => $trick,
      'formDeleteTrick'   => $formDeleteTrick->createView(),
      ));
    }
}

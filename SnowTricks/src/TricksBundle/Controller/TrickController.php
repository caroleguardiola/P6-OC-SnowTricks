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
  	    // Création de l'entité Advert
      $trick = new Trick();
      $trick->setName('Tail Grab');
      $trick->setDescription("Saisie de la partie arrière de la planche, avec la main arrière");

      // Création de l'entité Image
      $image1 = new Image();
      $image1->setUrl('http://twistedsifter.files.wordpress.com/2011/01/perfect-tail-grab.jpg');
      $image1->setAlt('Tail Grab Snowboard');

      $image2 = new Image();
      $image2->setUrl('http://twistedsifter.files.wordpress.com/2011/01/tail-grab.jpg');
      $image2->setAlt('Tail Grab Snowboard');

       // Création de l'entité Video
      $video = new Video();
      $video->setUrl('https://www.youtube.com/embed/id8VKl9RVQw');

      // Création de l'entité Category
      $category = new Category();
      $category->setName('Grab');

      // On lie l'image au trick
      $trick->addImage($image1);
      $trick->addImage($image2);
      // On lie la video au trick
      $trick->addVideo($video);
      // On lie le trick à la catégorie
      $trick->setCategory($category);


      // On récupère l'EntityManager
      $em = $this->getDoctrine()->getManager();

      // Étape 1 : On « persiste » l'entité
      $em->persist($trick);

      // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
      // on devrait persister à la main les entités $image1, $image2, $video, $category
      // $em->persist($image1);
      //$em->persist($image2);
      //$em->persist($video);
      //$em->persist($category);

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
      $em = $this->getDoctrine()->getManager();
      // On récupère le trick $id
      $trick = $em->getRepository('TricksBundle:Trick')->find($id);
      if (null === $trick) {
        throw new NotFoundHttpException("Le trick d'id ".$id." n'existe pas.");
      }
      // La méthode findAll retourne toutes les catégories de la base de données
      $listCategories = $em->getRepository('TricksBundle:Category')->findAll();
      // On boucle sur les catégories pour les lier au trick
      foreach ($listCategories as $category) {
        $trick->addCategory($category);
      }
      // Pour persister le changement dans la relation, il faut persister l'entité propriétaire
      // Ici, Trick est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine
      // Étape 2 : On déclenche l'enregistrement
      $em->flush();

      if ($request->isMethod('POST')) {
        $request->getSession()->getFlashBag()->add('notice', 'Trick bien modifié.');
        return $this->redirectToRoute('tricks_homepage');
      }
      
      return $this->render('TricksBundle:Trick:edit.html.twig', array(
        'trick' => array()
      ));
    }
}

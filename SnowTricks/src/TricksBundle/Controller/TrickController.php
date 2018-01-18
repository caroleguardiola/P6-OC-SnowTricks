<?php

namespace TricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TrickController extends Controller
{
    public function indexAction()
    {
         $content = $this->render('TricksBundle:Trick:index.html.twig', array('listTricks' => array()));
    
    return new Response($content);
    }

    public function viewAction($id)
    {
    	 return $this->render('TricksBundle:Trick:view.html.twig', array(
      'trickDetails'  => array()));
    }

    public function addAction(Request $request)
	{
	    // Si la requête est en POST, c'est que le visiteur a soumis le formulaire
	    if ($request->isMethod('POST')) {
	      $request->getSession()->getFlashBag()->add('notice', 'Trick bien enregistré.');
	      // Puis on redirige vers la page de visualisation de cettte annonce
	      return $this->redirectToRoute('tricks_homepage', array('id' => 5));
	    }
	    // Si on n'est pas en POST, alors on affiche le formulaire
	    return $this->render('TricksBundle:Trick:add.html.twig');
	}
}

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

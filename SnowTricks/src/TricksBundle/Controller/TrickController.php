<?php

namespace TricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
}

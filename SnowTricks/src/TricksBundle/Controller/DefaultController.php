<?php

namespace TricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TricksBundle:Default:index.html.twig');
    }
}

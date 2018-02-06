<?php

namespace ST\TricksBundle\Controller;

use ST\TricksBundle\Entity\Trick;
use ST\TricksBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageController extends Controller
{
    public function deleteAction(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();
      $image = $em->getRepository('TricksBundle:Image')->find($id);

      $trick = $image->getTrick()->getId();

      if (null === $image) {
        throw new NotFoundHttpException("L'image d'id ".$id." n'existe pas.");
      }

      $form = $this->get('form.factory')->create();
        

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em->remove($image);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "L'image a bien été supprimée.");

        return $this->redirectToRoute('tricks_home', array('trick' => $trick));
      }

       return $this->render('TricksBundle:Trick:delete_image.html.twig', array(
      'image' => $image,
      'form'   => $form->createView(),
      ));
    }
}

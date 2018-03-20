<?php

namespace ST\TricksBundle\Controller;

use ST\TricksBundle\Entity\Trick;
use ST\TricksBundle\Entity\Image;
use ST\TricksBundle\Form\ImageType;
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

        if (null === $image) {
            throw new NotFoundHttpException("L'image d'id ".$id." n'existe pas.");
        }

        $trick = $image->getTrick();

        $formDeleteImage = $this->get('form.factory')->create();
        

        if ($request->isMethod('POST')) {
            if ($formDeleteImage->handleRequest($request)->isValid()) {
                $em->remove($image);
                $em->flush();
                $this->addFlash('notice', "L'image a bien été supprimée.");
                return $this->redirectToRoute('tricks_edit', ['id' => $trick->getId()]);
            } else {
                $this->addFlash('error', 'L\'image n\'a pas pu être supprimée.');
            }
        }

        return $this->render('TricksBundle:Trick:delete_image.html.twig', array(
      'image' => $image,
      'formDeleteImage'   => $formDeleteImage->createView(),
      ));
    }
}

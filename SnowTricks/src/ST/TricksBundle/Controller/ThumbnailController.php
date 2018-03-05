<?php

namespace ST\TricksBundle\Controller;

use ST\TricksBundle\Entity\Trick;
use ST\TricksBundle\Entity\Thumbnail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ThumbnailController extends Controller
{
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $thumbnail = $em->getRepository('TricksBundle:Thumbnail')->find($id);

        if (null === $thumbnail) {
            throw new NotFoundHttpException("L'image à la une d'id ".$id." n'existe pas.");
        }

        $trick = $thumbnail->getTrick();

        $form = $this->get('form.factory')->create();
        

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($thumbnail);
            $em->flush();
            $this->addFlash('notice', "L'image à la une a bien été supprimée.");
            return $this->redirectToRoute('tricks_edit', ['id' => $trick->getId()]);
        }

        return $this->render('TricksBundle:Trick:delete_thumbnail.html.twig', array(
      'thumbnail' => $thumbnail,
      'form'   => $form->createView(),
      ));
    }
}

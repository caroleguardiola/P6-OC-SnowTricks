<?php

namespace ST\TricksBundle\Controller;

use ST\TricksBundle\Entity\Trick;
use ST\TricksBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VideoController extends Controller
{
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $video = $em->getRepository('TricksBundle:Video')->find($id);

        if (null === $video) {
            throw new NotFoundHttpException("La video d'id ".$id." n'existe pas.");
        }

        $trick = $video->getTrick();

        $form = $this->get('form.factory')->create();
        

       if ($request->isMethod('POST')) {
            if($form->handleRequest($request)->isValid()) {
                $em->remove($video);
                $em->flush();
                $this->addFlash('notice', "La video a bien été supprimée.");
                return $this->redirectToRoute('tricks_edit', ['id' => $trick->getId()]);
            }else{
                $this->addFlash('error', 'La vidéo n\'a pas pu être supprimée.');
            }
        }

        return $this->render('TricksBundle:Trick:delete_video.html.twig', array(
      'video' => $video,
      'form'   => $form->createView(),
      ));
    }
}

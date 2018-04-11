<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Carole Guardiola <carole.guardiola@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class VideoController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $video = $em->getRepository('AppBundle:Video')->find($id);

        if (null === $video) {
            throw new NotFoundHttpException("La video d'id ".$id." n'existe pas.");
        }

        $trick = $video->getTrick();

        $formDeleteVideo = $this->get('form.factory')->create();
        

        if ($request->isMethod('POST')) {
            if ($formDeleteVideo->handleRequest($request)->isValid()) {
                $em->remove($video);
                $em->flush();
                $this->addFlash('notice', "La video a bien été supprimée.");
                return $this->redirectToRoute('tricks_edit', ['id' => $trick->getId()]);
            }
            $this->addFlash('error', 'La vidéo n\'a pas pu être supprimée.');
        }

        return $this->render('AppBundle:Trick:delete_video.html.twig', array(
      'video' => $video,
      'formDeleteVideo'   => $formDeleteVideo->createView(),
      ));
    }
}

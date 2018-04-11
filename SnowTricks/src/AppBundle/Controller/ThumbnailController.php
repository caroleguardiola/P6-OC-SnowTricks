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

class ThumbnailController extends Controller
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
        $thumbnail = $em->getRepository('AppBundle:Thumbnail')->find($id);

        if (null === $thumbnail) {
            throw new NotFoundHttpException("L'image à la une d'id ".$id." n'existe pas.");
        }

        $trick = $thumbnail->getTrick();

        $formDeleteThumb = $this->get('form.factory')->create();
        

        if ($request->isMethod('POST')) {
            if ($formDeleteThumb->handleRequest($request)->isValid()) {
                $em->remove($thumbnail);
                $em->flush();
                $this->addFlash('notice', "L'image à la une a bien été supprimée.");
                return $this->redirectToRoute('tricks_edit', ['id' => $trick->getId()]);
            }
            $this->addFlash('error', 'L\'image à la une n\'a pas pu être supprimée.');
        }

        return $this->render('AppBundle:Trick:delete_thumbnail.html.twig', array(
      'thumbnail' => $thumbnail,
      'formDeleteThumb'   => $formDeleteThumb->createView(),
      ));
    }
}

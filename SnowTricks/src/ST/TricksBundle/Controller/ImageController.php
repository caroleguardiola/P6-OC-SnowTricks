<?php

namespace ST\TricksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ImageController extends Controller
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
            }
            $this->addFlash('error', 'L\'image n\'a pas pu être supprimée.');
        }

        return $this->render('TricksBundle:Trick:delete_image.html.twig', array(
      'image' => $image,
      'formDeleteImage'   => $formDeleteImage->createView(),
      ));
    }
}

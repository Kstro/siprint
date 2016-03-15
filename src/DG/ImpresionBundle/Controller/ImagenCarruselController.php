<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\ImagenCarrusel;
use DG\ImpresionBundle\Form\ImagenCarruselType;

/**
 * ImagenCarrusel controller.
 *
 * @Route("/admin/image-carousel")
 */
class ImagenCarruselController extends Controller
{
    /**
     * Lists all ImagenCarrusel entities.
     *
     * @Route("/", name="admin_image-carousel_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imagenCarrusels = $em->getRepository('DGImpresionBundle:ImagenCarrusel')->findAll();

        return $this->render('imagencarrusel/index.html.twig', array(
            'imagenCarrusels' => $imagenCarrusels,
        ));
    }

    /**
     * Creates a new ImagenCarrusel entity.
     *
     * @Route("/new", name="admin_image-carousel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $imagenCarrusel = new ImagenCarrusel();
        $form = $this->createForm('DG\ImpresionBundle\Form\ImagenCarruselType', $imagenCarrusel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imagenCarrusel);
            $em->flush();

            return $this->redirectToRoute('admin_image-carousel_show', array('id' => $imagencarrusel->getId()));
        }

        return $this->render('imagencarrusel/new.html.twig', array(
            'imagenCarrusel' => $imagenCarrusel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ImagenCarrusel entity.
     *
     * @Route("/{id}", name="admin_image-carousel_show")
     * @Method("GET")
     */
    public function showAction(ImagenCarrusel $imagenCarrusel)
    {
        $deleteForm = $this->createDeleteForm($imagenCarrusel);

        return $this->render('imagencarrusel/show.html.twig', array(
            'imagenCarrusel' => $imagenCarrusel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ImagenCarrusel entity.
     *
     * @Route("/{id}/edit", name="admin_image-carousel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ImagenCarrusel $imagenCarrusel)
    {
        $deleteForm = $this->createDeleteForm($imagenCarrusel);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\ImagenCarruselType', $imagenCarrusel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imagenCarrusel);
            $em->flush();

            return $this->redirectToRoute('admin_image-carousel_edit', array('id' => $imagenCarrusel->getId()));
        }

        return $this->render('imagencarrusel/edit.html.twig', array(
            'imagenCarrusel' => $imagenCarrusel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ImagenCarrusel entity.
     *
     * @Route("/{id}", name="admin_image-carousel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ImagenCarrusel $imagenCarrusel)
    {
        $form = $this->createDeleteForm($imagenCarrusel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($imagenCarrusel);
            $em->flush();
        }

        return $this->redirectToRoute('admin_image-carousel_index');
    }

    /**
     * Creates a form to delete a ImagenCarrusel entity.
     *
     * @param ImagenCarrusel $imagenCarrusel The ImagenCarrusel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImagenCarrusel $imagenCarrusel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_image-carousel_delete', array('id' => $imagenCarrusel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

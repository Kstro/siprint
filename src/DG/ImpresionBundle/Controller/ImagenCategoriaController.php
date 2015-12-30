<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\ImagenCategoria;
use DG\ImpresionBundle\Form\ImagenCategoriaType;

/**
 * ImagenCategoria controller.
 *
 * @Route("/admin/imagencategoria")
 */
class ImagenCategoriaController extends Controller
{
    /**
     * Lists all ImagenCategoria entities.
     *
     * @Route("/", name="admin_imagencategoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imagenCategorias = $em->getRepository('DGImpresionBundle:ImagenCategoria')->findAll();

        return $this->render('imagencategoria/index.html.twig', array(
            'imagenCategorias' => $imagenCategorias,
        ));
    }

    /**
     * Creates a new ImagenCategoria entity.
     *
     * @Route("/new", name="admin_imagencategoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $imagenCategorium = new ImagenCategoria();
        $form = $this->createForm('DG\ImpresionBundle\Form\ImagenCategoriaType', $imagenCategorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imagenCategorium);
            $em->flush();

            return $this->redirectToRoute('admin_imagencategoria_show', array('id' => $imagencategoria->getId()));
        }

        return $this->render('imagencategoria/new.html.twig', array(
            'imagenCategorium' => $imagenCategorium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ImagenCategoria entity.
     *
     * @Route("/{id}", name="admin_imagencategoria_show")
     * @Method("GET")
     */
    public function showAction(ImagenCategoria $imagenCategorium)
    {
        $deleteForm = $this->createDeleteForm($imagenCategorium);

        return $this->render('imagencategoria/show.html.twig', array(
            'imagenCategorium' => $imagenCategorium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ImagenCategoria entity.
     *
     * @Route("/{id}/edit", name="admin_imagencategoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ImagenCategoria $imagenCategorium)
    {
        $deleteForm = $this->createDeleteForm($imagenCategorium);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\ImagenCategoriaType', $imagenCategorium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($imagenCategorium);
            $em->flush();

            return $this->redirectToRoute('admin_imagencategoria_edit', array('id' => $imagenCategorium->getId()));
        }

        return $this->render('imagencategoria/edit.html.twig', array(
            'imagenCategorium' => $imagenCategorium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ImagenCategoria entity.
     *
     * @Route("/{id}", name="admin_imagencategoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ImagenCategoria $imagenCategorium)
    {
        $form = $this->createDeleteForm($imagenCategorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($imagenCategorium);
            $em->flush();
        }

        return $this->redirectToRoute('admin_imagencategoria_index');
    }

    /**
     * Creates a form to delete a ImagenCategoria entity.
     *
     * @param ImagenCategoria $imagenCategorium The ImagenCategoria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImagenCategoria $imagenCategorium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_imagencategoria_delete', array('id' => $imagenCategorium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\DetalleCategoria;
use DG\ImpresionBundle\Form\DetalleCategoriaType;

/**
 * DetalleCategoria controller.
 *
 * @Route("/detallecategoria")
 */
class DetalleCategoriaController extends Controller
{
    /**
     * Lists all DetalleCategoria entities.
     *
     * @Route("/", name="detallecategoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $detalleCategorias = $em->getRepository('DGImpresionBundle:DetalleCategoria')->findAll();

        return $this->render('detallecategoria/index.html.twig', array(
            'detalleCategorias' => $detalleCategorias,
        ));
    }

    /**
     * Creates a new DetalleCategoria entity.
     *
     * @Route("/new", name="detallecategoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $detalleCategorium = new DetalleCategoria();
        $form = $this->createForm('DG\ImpresionBundle\Form\DetalleCategoriaType', $detalleCategorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($detalleCategorium);
            $em->flush();

            return $this->redirectToRoute('detallecategoria_show', array('id' => $detallecategoria->getId()));
        }

        return $this->render('detallecategoria/new.html.twig', array(
            'detalleCategorium' => $detalleCategorium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DetalleCategoria entity.
     *
     * @Route("/{id}", name="detallecategoria_show")
     * @Method("GET")
     */
    public function showAction(DetalleCategoria $detalleCategorium)
    {
        $deleteForm = $this->createDeleteForm($detalleCategorium);

        return $this->render('detallecategoria/show.html.twig', array(
            'detalleCategorium' => $detalleCategorium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DetalleCategoria entity.
     *
     * @Route("/{id}/edit", name="detallecategoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DetalleCategoria $detalleCategorium)
    {
        $deleteForm = $this->createDeleteForm($detalleCategorium);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\DetalleCategoriaType', $detalleCategorium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($detalleCategorium);
            $em->flush();

            return $this->redirectToRoute('detallecategoria_edit', array('id' => $detalleCategorium->getId()));
        }

        return $this->render('detallecategoria/edit.html.twig', array(
            'detalleCategorium' => $detalleCategorium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a DetalleCategoria entity.
     *
     * @Route("/{id}", name="detallecategoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DetalleCategoria $detalleCategorium)
    {
        $form = $this->createDeleteForm($detalleCategorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($detalleCategorium);
            $em->flush();
        }

        return $this->redirectToRoute('detallecategoria_index');
    }

    /**
     * Creates a form to delete a DetalleCategoria entity.
     *
     * @param DetalleCategoria $detalleCategorium The DetalleCategoria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DetalleCategoria $detalleCategorium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('detallecategoria_delete', array('id' => $detalleCategorium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

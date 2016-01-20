<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\DetalleOrden;
use DG\ImpresionBundle\Form\DetalleOrdenType;

/**
 * DetalleOrden controller.
 *
 * @Route("/admin/detalleorden")
 */
class DetalleOrdenController extends Controller
{
    /**
     * Lists all DetalleOrden entities.
     *
     * @Route("/", name="admin_detalleorden_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $detalleOrdens = $em->getRepository('DGImpresionBundle:DetalleOrden')->findAll();

        return $this->render('detalleorden/index.html.twig', array(
            'detalleOrdens' => $detalleOrdens,
        ));
    }

    /**
     * Creates a new DetalleOrden entity.
     *
     * @Route("/new", name="admin_detalleorden_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $detalleOrden = new DetalleOrden();
        $form = $this->createForm('DG\ImpresionBundle\Form\DetalleOrdenType', $detalleOrden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($detalleOrden);
            $em->flush();

            return $this->redirectToRoute('admin_detalleorden_show', array('id' => $detalleOrden->getId()));
        }

        return $this->render('detalleorden/new.html.twig', array(
            'detalleOrden' => $detalleOrden,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DetalleOrden entity.
     *
     * @Route("/{id}", name="admin_detalleorden_show")
     * @Method("GET")
     */
    public function showAction(DetalleOrden $detalleOrden)
    {
        $deleteForm = $this->createDeleteForm($detalleOrden);

        return $this->render('detalleorden/show.html.twig', array(
            'detalleOrden' => $detalleOrden,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DetalleOrden entity.
     *
     * @Route("/{id}/edit", name="admin_detalleorden_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DetalleOrden $detalleOrden)
    {
        $deleteForm = $this->createDeleteForm($detalleOrden);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\DetalleOrdenType', $detalleOrden);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($detalleOrden);
            $em->flush();

            return $this->redirectToRoute('admin_detalleorden_edit', array('id' => $detalleOrden->getId()));
        }

        return $this->render('detalleorden/edit.html.twig', array(
            'detalleOrden' => $detalleOrden,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a DetalleOrden entity.
     *
     * @Route("/{id}", name="admin_detalleorden_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DetalleOrden $detalleOrden)
    {
        $form = $this->createDeleteForm($detalleOrden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($detalleOrden);
            $em->flush();
        }

        return $this->redirectToRoute('admin_detalleorden_index');
    }

    /**
     * Creates a form to delete a DetalleOrden entity.
     *
     * @param DetalleOrden $detalleOrden The DetalleOrden entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DetalleOrden $detalleOrden)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_detalleorden_delete', array('id' => $detalleOrden->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

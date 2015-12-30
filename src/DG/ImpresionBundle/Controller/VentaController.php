<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Venta;
use DG\ImpresionBundle\Form\VentaType;

/**
 * Venta controller.
 *
 * @Route("/admin/venta")
 */
class VentaController extends Controller
{
    /**
     * Lists all Venta entities.
     *
     * @Route("/", name="admin_venta_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ventas = $em->getRepository('DGImpresionBundle:Venta')->findAll();

        return $this->render('venta/index.html.twig', array(
            'ventas' => $ventas,
        ));
    }

    /**
     * Creates a new Venta entity.
     *
     * @Route("/new", name="admin_venta_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ventum = new Venta();
        $form = $this->createForm('DG\ImpresionBundle\Form\VentaType', $ventum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ventum);
            $em->flush();

            return $this->redirectToRoute('admin_venta_show', array('id' => $venta->getId()));
        }

        return $this->render('venta/new.html.twig', array(
            'ventum' => $ventum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Venta entity.
     *
     * @Route("/{id}", name="admin_venta_show")
     * @Method("GET")
     */
    public function showAction(Venta $ventum)
    {
        $deleteForm = $this->createDeleteForm($ventum);

        return $this->render('venta/show.html.twig', array(
            'ventum' => $ventum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Venta entity.
     *
     * @Route("/{id}/edit", name="admin_venta_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Venta $ventum)
    {
        $deleteForm = $this->createDeleteForm($ventum);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\VentaType', $ventum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ventum);
            $em->flush();

            return $this->redirectToRoute('admin_venta_edit', array('id' => $ventum->getId()));
        }

        return $this->render('venta/edit.html.twig', array(
            'ventum' => $ventum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Venta entity.
     *
     * @Route("/{id}", name="admin_venta_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Venta $ventum)
    {
        $form = $this->createDeleteForm($ventum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ventum);
            $em->flush();
        }

        return $this->redirectToRoute('admin_venta_index');
    }

    /**
     * Creates a form to delete a Venta entity.
     *
     * @param Venta $ventum The Venta entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Venta $ventum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_venta_delete', array('id' => $ventum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

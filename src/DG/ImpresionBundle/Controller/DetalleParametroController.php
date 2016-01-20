<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\DetalleParametro;
use DG\ImpresionBundle\Form\DetalleParametroType;

/**
 * DetalleParametro controller.
 *
 * @Route("/admin/detalleparametro")
 */
class DetalleParametroController extends Controller
{
    /**
     * Lists all DetalleParametro entities.
     *
     * @Route("/", name="admin_detalleparametro_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $detalleParametros = $em->getRepository('DGImpresionBundle:DetalleParametro')->findAll();

        return $this->render('detalleparametro/index.html.twig', array(
            'detalleParametros' => $detalleParametros,
        ));
    }

    /**
     * Creates a new DetalleParametro entity.
     *
     * @Route("/new", name="admin_detalleparametro_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $detalleParametro = new DetalleParametro();
        $form = $this->createForm('DG\ImpresionBundle\Form\DetalleParametroType', $detalleParametro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            
            
            
            
            
            
            $em->persist($detalleParametro);
            $em->flush();

            return $this->redirectToRoute('admin_detalleparametro_show', array('id' => $detalleparametro->getId()));
        }

        return $this->render('detalleparametro/new.html.twig', array(
            'detalleParametro' => $detalleParametro,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DetalleParametro entity.
     *
     * @Route("/{id}", name="admin_detalleparametro_show")
     * @Method("GET")
     */
    public function showAction(DetalleParametro $detalleParametro)
    {
        $deleteForm = $this->createDeleteForm($detalleParametro);

        return $this->render('detalleparametro/show.html.twig', array(
            'detalleParametro' => $detalleParametro,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DetalleParametro entity.
     *
     * @Route("/{id}/edit", name="admin_detalleparametro_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DetalleParametro $detalleParametro)
    {
        $deleteForm = $this->createDeleteForm($detalleParametro);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\DetalleParametroType', $detalleParametro);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($detalleParametro);
            $em->flush();

            return $this->redirectToRoute('admin_detalleparametro_edit', array('id' => $detalleParametro->getId()));
        }

        return $this->render('detalleparametro/edit.html.twig', array(
            'detalleParametro' => $detalleParametro,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a DetalleParametro entity.
     *
     * @Route("/{id}", name="admin_detalleparametro_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DetalleParametro $detalleParametro)
    {
        $form = $this->createDeleteForm($detalleParametro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($detalleParametro);
            $em->flush();
        }

        return $this->redirectToRoute('admin_detalleparametro_index');
    }

    /**
     * Creates a form to delete a DetalleParametro entity.
     *
     * @param DetalleParametro $detalleParametro The DetalleParametro entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DetalleParametro $detalleParametro)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_detalleparametro_delete', array('id' => $detalleParametro->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

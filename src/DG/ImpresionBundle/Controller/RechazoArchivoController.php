<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\RechazoArchivo;
use DG\ImpresionBundle\Entity\DetalleOrden;
use DG\ImpresionBundle\Form\RechazoArchivoType;

/**
 * RechazoArchivo controller.
 *
 * @Route("/admin/disapprove-design")
 */
class RechazoArchivoController extends Controller
{
    /**
     * Lists all RechazoArchivo entities.
     *
     * @Route("/", name="admin_disapprovedesign_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rechazoArchivos = $em->getRepository('DGImpresionBundle:RechazoArchivo')->findAll();

        return $this->render('rechazoarchivo/index.html.twig', array(
            'rechazoArchivos' => $rechazoArchivos,
        ));
    }

    /**
     * Creates a new RechazoArchivo entity.
     *
     * @Route("/{id}/new", name="admin_disapprovedesign_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, DetalleOrden $detalleOrden)
    {
        $rechazoArchivo = new RechazoArchivo();
        $form = $this->createForm('DG\ImpresionBundle\Form\RechazoArchivoType', $rechazoArchivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $detalleOrden->setEstado('df');
            $em->merge($detalleOrden);
            $em->flush();
            
            $rechazoArchivo->setArchivo($detalleOrden->getArchivo());
            $rechazoArchivo->setDetalleOrden($detalleOrden);
            $em->persist($rechazoArchivo);
            $em->flush();
            
            $this->get('envio_correo')->sendEmail("anthony@digitalitygarage.com","","","","prueba1");
            

            return $this->redirectToRoute('admin_detalleorden_show', array('id' => $detalleOrden->getId()));
        }

        return $this->render('rechazoarchivo/new.html.twig', array(
            'rechazoArchivo' => $rechazoArchivo,
            'detalleOrden'   => $detalleOrden,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a RechazoArchivo entity.
     *
     * @Route("/{id}", name="admin_disapprovedesign_show")
     * @Method("GET")
     */
    public function showAction(RechazoArchivo $rechazoArchivo)
    {
        $deleteForm = $this->createDeleteForm($rechazoArchivo);

        return $this->render('rechazoarchivo/show.html.twig', array(
            'rechazoArchivo' => $rechazoArchivo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing RechazoArchivo entity.
     *
     * @Route("/{id}/edit", name="admin_disapprovedesign_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RechazoArchivo $rechazoArchivo)
    {
        $deleteForm = $this->createDeleteForm($rechazoArchivo);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\RechazoArchivoType', $rechazoArchivo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rechazoArchivo);
            $em->flush();

            return $this->redirectToRoute('admin_disapprovedesign_edit', array('id' => $rechazoArchivo->getId()));
        }

        return $this->render('rechazoarchivo/edit.html.twig', array(
            'rechazoArchivo' => $rechazoArchivo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a RechazoArchivo entity.
     *
     * @Route("/{id}", name="admin_disapprovedesign_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RechazoArchivo $rechazoArchivo)
    {
        $form = $this->createDeleteForm($rechazoArchivo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rechazoArchivo);
            $em->flush();
        }

        return $this->redirectToRoute('admin_disapprovedesign_index');
    }

    /**
     * Creates a form to delete a RechazoArchivo entity.
     *
     * @param RechazoArchivo $rechazoArchivo The RechazoArchivo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RechazoArchivo $rechazoArchivo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_disapprovedesign_delete', array('id' => $rechazoArchivo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

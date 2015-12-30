<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Bitacora;
use DG\ImpresionBundle\Form\BitacoraType;

/**
 * Bitacora controller.
 *
 * @Route("/admin/bitacora")
 */
class BitacoraController extends Controller
{
    /**
     * Lists all Bitacora entities.
     *
     * @Route("/", name="admin_bitacora_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $bitacoras = $em->getRepository('DGImpresionBundle:Bitacora')->findAll();

        return $this->render('bitacora/index.html.twig', array(
            'bitacoras' => $bitacoras,
        ));
    }

    /**
     * Creates a new Bitacora entity.
     *
     * @Route("/new", name="admin_bitacora_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bitacora = new Bitacora();
        $form = $this->createForm('DG\ImpresionBundle\Form\BitacoraType', $bitacora);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bitacora);
            $em->flush();

            return $this->redirectToRoute('admin_bitacora_show', array('id' => $bitacora->getId()));
        }

        return $this->render('bitacora/new.html.twig', array(
            'bitacora' => $bitacora,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Bitacora entity.
     *
     * @Route("/{id}", name="admin_bitacora_show")
     * @Method("GET")
     */
    public function showAction(Bitacora $bitacora)
    {
        $deleteForm = $this->createDeleteForm($bitacora);

        return $this->render('bitacora/show.html.twig', array(
            'bitacora' => $bitacora,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Bitacora entity.
     *
     * @Route("/{id}/edit", name="admin_bitacora_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Bitacora $bitacora)
    {
        $deleteForm = $this->createDeleteForm($bitacora);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\BitacoraType', $bitacora);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bitacora);
            $em->flush();

            return $this->redirectToRoute('admin_bitacora_edit', array('id' => $bitacora->getId()));
        }

        return $this->render('bitacora/edit.html.twig', array(
            'bitacora' => $bitacora,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Bitacora entity.
     *
     * @Route("/{id}", name="admin_bitacora_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Bitacora $bitacora)
    {
        $form = $this->createDeleteForm($bitacora);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bitacora);
            $em->flush();
        }

        return $this->redirectToRoute('admin_bitacora_index');
    }

    /**
     * Creates a form to delete a Bitacora entity.
     *
     * @param Bitacora $bitacora The Bitacora entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bitacora $bitacora)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_bitacora_delete', array('id' => $bitacora->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

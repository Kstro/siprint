<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Orden;
use DG\ImpresionBundle\Form\OrdenType;

/**
 * Orden controller.
 *
 * @Route("/orden")
 */
class OrdenController extends Controller
{
    /**
     * Lists all Orden entities.
     *
     * @Route("/", name="orden_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ordens = $em->getRepository('DGImpresionBundle:Orden')->findAll();

        return $this->render('orden/index.html.twig', array(
            'ordens' => $ordens,
        ));
    }

    /**
     * Creates a new Orden entity.
     *
     * @Route("/new", name="orden_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $orden = new Orden();
        $form = $this->createForm('DG\ImpresionBundle\Form\OrdenType', $orden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($orden);
            $em->flush();

            return $this->redirectToRoute('orden_show', array('id' => $orden->getId()));
        }

        return $this->render('orden/new.html.twig', array(
            'orden' => $orden,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Orden entity.
     *
     * @Route("/{id}", name="orden_show")
     * @Method("GET")
     */
    public function showAction(Orden $orden)
    {
        $deleteForm = $this->createDeleteForm($orden);

        return $this->render('orden/show.html.twig', array(
            'orden' => $orden,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Orden entity.
     *
     * @Route("/{id}/edit", name="orden_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Orden $orden)
    {
        $deleteForm = $this->createDeleteForm($orden);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\OrdenType', $orden);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($orden);
            $em->flush();

            return $this->redirectToRoute('orden_edit', array('id' => $orden->getId()));
        }

        return $this->render('orden/edit.html.twig', array(
            'orden' => $orden,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Orden entity.
     *
     * @Route("/{id}", name="orden_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Orden $orden)
    {
        $form = $this->createDeleteForm($orden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($orden);
            $em->flush();
        }

        return $this->redirectToRoute('orden_index');
    }

    /**
     * Creates a form to delete a Orden entity.
     *
     * @param Orden $orden The Orden entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Orden $orden)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orden_delete', array('id' => $orden->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Suscripcion;
use DG\ImpresionBundle\Form\SuscripcionType;

/**
 * Suscripcion controller.
 *
 * @Route("/suscripcion")
 */
class SuscripcionController extends Controller
{
    /**
     * Lists all Suscripcion entities.
     *
     * @Route("/", name="suscripcion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $suscripcions = $em->getRepository('DGImpresionBundle:Suscripcion')->findAll();

        return $this->render('suscripcion/index.html.twig', array(
            'suscripcions' => $suscripcions,
        ));
    }

    /**
     * Creates a new Suscripcion entity.
     *
     * @Route("/new", name="suscripcion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $suscripcion = new Suscripcion();
        $form = $this->createForm('DG\ImpresionBundle\Form\SuscripcionType', $suscripcion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($suscripcion);
            $em->flush();

            return $this->redirectToRoute('suscripcion_show', array('id' => $suscripcion->getId()));
        }

        return $this->render('suscripcion/new.html.twig', array(
            'suscripcion' => $suscripcion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Suscripcion entity.
     *
     * @Route("/{id}", name="suscripcion_show")
     * @Method("GET")
     */
    public function showAction(Suscripcion $suscripcion)
    {
        $deleteForm = $this->createDeleteForm($suscripcion);

        return $this->render('suscripcion/show.html.twig', array(
            'suscripcion' => $suscripcion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Suscripcion entity.
     *
     * @Route("/{id}/edit", name="suscripcion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Suscripcion $suscripcion)
    {
        $deleteForm = $this->createDeleteForm($suscripcion);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\SuscripcionType', $suscripcion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($suscripcion);
            $em->flush();

            return $this->redirectToRoute('suscripcion_edit', array('id' => $suscripcion->getId()));
        }

        return $this->render('suscripcion/edit.html.twig', array(
            'suscripcion' => $suscripcion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Suscripcion entity.
     *
     * @Route("/{id}", name="suscripcion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Suscripcion $suscripcion)
    {
        $form = $this->createDeleteForm($suscripcion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($suscripcion);
            $em->flush();
        }

        return $this->redirectToRoute('suscripcion_index');
    }

    /**
     * Creates a form to delete a Suscripcion entity.
     *
     * @param Suscripcion $suscripcion The Suscripcion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Suscripcion $suscripcion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('suscripcion_delete', array('id' => $suscripcion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

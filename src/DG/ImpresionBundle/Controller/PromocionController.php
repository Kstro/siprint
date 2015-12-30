<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Promocion;
use DG\ImpresionBundle\Form\PromocionType;

/**
 * Promocion controller.
 *
 * @Route("/admin/promocion")
 */
class PromocionController extends Controller
{
    /**
     * Lists all Promocion entities.
     *
     * @Route("/", name="admin_promocion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $promocions = $em->getRepository('DGImpresionBundle:Promocion')->findAll();

        return $this->render('promocion/index.html.twig', array(
            'promocions' => $promocions,
        ));
    }

    /**
     * Creates a new Promocion entity.
     *
     * @Route("/new", name="admin_promocion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $promocion = new Promocion();
        $form = $this->createForm('DG\ImpresionBundle\Form\PromocionType', $promocion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promocion);
            $em->flush();

            return $this->redirectToRoute('admin_promocion_show', array('id' => $promocion->getId()));
        }

        return $this->render('promocion/new.html.twig', array(
            'promocion' => $promocion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Promocion entity.
     *
     * @Route("/{id}", name="admin_promocion_show")
     * @Method("GET")
     */
    public function showAction(Promocion $promocion)
    {
        $deleteForm = $this->createDeleteForm($promocion);

        return $this->render('promocion/show.html.twig', array(
            'promocion' => $promocion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Promocion entity.
     *
     * @Route("/{id}/edit", name="admin_promocion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Promocion $promocion)
    {
        $deleteForm = $this->createDeleteForm($promocion);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\PromocionType', $promocion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promocion);
            $em->flush();

            return $this->redirectToRoute('admin_promocion_edit', array('id' => $promocion->getId()));
        }

        return $this->render('promocion/edit.html.twig', array(
            'promocion' => $promocion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Promocion entity.
     *
     * @Route("/{id}", name="admin_promocion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Promocion $promocion)
    {
        $form = $this->createDeleteForm($promocion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($promocion);
            $em->flush();
        }

        return $this->redirectToRoute('admin_promocion_index');
    }

    /**
     * Creates a form to delete a Promocion entity.
     *
     * @param Promocion $promocion The Promocion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Promocion $promocion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_promocion_delete', array('id' => $promocion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

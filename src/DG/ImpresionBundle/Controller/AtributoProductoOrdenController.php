<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\AtributoProductoOrden;
use DG\ImpresionBundle\Form\AtributoProductoOrdenType;

/**
 * AtributoProductoOrden controller.
 *
 * @Route("/atributoproductoorden")
 */
class AtributoProductoOrdenController extends Controller
{
    /**
     * Lists all AtributoProductoOrden entities.
     *
     * @Route("/", name="atributoproductoorden_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $atributoProductoOrdens = $em->getRepository('DGImpresionBundle:AtributoProductoOrden')->findAll();

        return $this->render('atributoproductoorden/index.html.twig', array(
            'atributoProductoOrdens' => $atributoProductoOrdens,
        ));
    }

    /**
     * Creates a new AtributoProductoOrden entity.
     *
     * @Route("/new", name="atributoproductoorden_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $atributoProductoOrden = new AtributoProductoOrden();
        $form = $this->createForm('DG\ImpresionBundle\Form\AtributoProductoOrdenType', $atributoProductoOrden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($atributoProductoOrden);
            $em->flush();

            return $this->redirectToRoute('atributoproductoorden_show', array('id' => $atributoproductoorden->getId()));
        }

        return $this->render('atributoproductoorden/new.html.twig', array(
            'atributoProductoOrden' => $atributoProductoOrden,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AtributoProductoOrden entity.
     *
     * @Route("/{id}", name="atributoproductoorden_show")
     * @Method("GET")
     */
    public function showAction(AtributoProductoOrden $atributoProductoOrden)
    {
        $deleteForm = $this->createDeleteForm($atributoProductoOrden);

        return $this->render('atributoproductoorden/show.html.twig', array(
            'atributoProductoOrden' => $atributoProductoOrden,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AtributoProductoOrden entity.
     *
     * @Route("/{id}/edit", name="atributoproductoorden_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AtributoProductoOrden $atributoProductoOrden)
    {
        $deleteForm = $this->createDeleteForm($atributoProductoOrden);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\AtributoProductoOrdenType', $atributoProductoOrden);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($atributoProductoOrden);
            $em->flush();

            return $this->redirectToRoute('atributoproductoorden_edit', array('id' => $atributoProductoOrden->getId()));
        }

        return $this->render('atributoproductoorden/edit.html.twig', array(
            'atributoProductoOrden' => $atributoProductoOrden,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a AtributoProductoOrden entity.
     *
     * @Route("/{id}", name="atributoproductoorden_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AtributoProductoOrden $atributoProductoOrden)
    {
        $form = $this->createDeleteForm($atributoProductoOrden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($atributoProductoOrden);
            $em->flush();
        }

        return $this->redirectToRoute('atributoproductoorden_index');
    }

    /**
     * Creates a form to delete a AtributoProductoOrden entity.
     *
     * @param AtributoProductoOrden $atributoProductoOrden The AtributoProductoOrden entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AtributoProductoOrden $atributoProductoOrden)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('atributoproductoorden_delete', array('id' => $atributoProductoOrden->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Parametro;
use DG\ImpresionBundle\Form\ParametroType;

/**
 * Parametro controller.
 *
 * @Route("/admin/parametro")
 */
class ParametroController extends Controller
{
    /**
     * Lists all Parametro entities.
     *
     * @Route("/", name="admin_parametro_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $parametros = $em->getRepository('DGImpresionBundle:Parametro')->findAll();

        return $this->render('parametro/index.html.twig', array(
            'parametros' => $parametros,
        ));
    }

    /**
     * Creates a new Parametro entity.
     *
     * @Route("/new", name="admin_parametro_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $parametro = new Parametro();
        $form = $this->createForm('DG\ImpresionBundle\Form\ParametroType', $parametro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($parametro);
            $em->flush();

            return $this->redirectToRoute('admin_parametro_show', array('id' => $parametro->getId()));
        }

        return $this->render('parametro/new.html.twig', array(
            'parametro' => $parametro,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Parametro entity.
     *
     * @Route("/{id}", name="admin_parametro_show")
     * @Method("GET")
     */
    public function showAction(Parametro $parametro)
    {
        $deleteForm = $this->createDeleteForm($parametro);

        return $this->render('parametro/show.html.twig', array(
            'parametro' => $parametro,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Parametro entity.
     *
     * @Route("/{id}/edit", name="admin_parametro_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Parametro $parametro)
    {
        $deleteForm = $this->createDeleteForm($parametro);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\ParametroType', $parametro);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($parametro);
            $em->flush();

            return $this->redirectToRoute('admin_parametro_edit', array('id' => $parametro->getId()));
        }

        return $this->render('parametro/edit.html.twig', array(
            'parametro' => $parametro,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Parametro entity.
     *
     * @Route("/{id}", name="admin_parametro_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Parametro $parametro)
    {
        $form = $this->createDeleteForm($parametro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($parametro);
            $em->flush();
        }

        return $this->redirectToRoute('admin_parametro_index');
    }

    /**
     * Creates a form to delete a Parametro entity.
     *
     * @param Parametro $parametro The Parametro entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Parametro $parametro)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_parametro_delete', array('id' => $parametro->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

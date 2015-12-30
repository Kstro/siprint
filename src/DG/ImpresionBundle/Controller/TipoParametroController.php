<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\TipoParametro;
use DG\ImpresionBundle\Form\TipoParametroType;

/**
 * TipoParametro controller.
 *
 * @Route("/admin/tipoparametro")
 */
class TipoParametroController extends Controller
{
    /**
     * Lists all TipoParametro entities.
     *
     * @Route("/", name="admin_tipoparametro_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipoParametros = $em->getRepository('DGImpresionBundle:TipoParametro')->findAll();

        return $this->render('tipoparametro/index.html.twig', array(
            'tipoParametros' => $tipoParametros,
        ));
    }

    /**
     * Creates a new TipoParametro entity.
     *
     * @Route("/new", name="admin_tipoparametro_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipoParametro = new TipoParametro();
        $form = $this->createForm('DG\ImpresionBundle\Form\TipoParametroType', $tipoParametro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoParametro);
            $em->flush();

            return $this->redirectToRoute('admin_tipoparametro_show', array('id' => $tipoparametro->getId()));
        }

        return $this->render('tipoparametro/new.html.twig', array(
            'tipoParametro' => $tipoParametro,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoParametro entity.
     *
     * @Route("/{id}", name="admin_tipoparametro_show")
     * @Method("GET")
     */
    public function showAction(TipoParametro $tipoParametro)
    {
        $deleteForm = $this->createDeleteForm($tipoParametro);

        return $this->render('tipoparametro/show.html.twig', array(
            'tipoParametro' => $tipoParametro,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoParametro entity.
     *
     * @Route("/{id}/edit", name="admin_tipoparametro_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TipoParametro $tipoParametro)
    {
        $deleteForm = $this->createDeleteForm($tipoParametro);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\TipoParametroType', $tipoParametro);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoParametro);
            $em->flush();

            return $this->redirectToRoute('admin_tipoparametro_edit', array('id' => $tipoParametro->getId()));
        }

        return $this->render('tipoparametro/edit.html.twig', array(
            'tipoParametro' => $tipoParametro,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TipoParametro entity.
     *
     * @Route("/{id}", name="admin_tipoparametro_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TipoParametro $tipoParametro)
    {
        $form = $this->createDeleteForm($tipoParametro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoParametro);
            $em->flush();
        }

        return $this->redirectToRoute('admin_tipoparametro_index');
    }

    /**
     * Creates a form to delete a TipoParametro entity.
     *
     * @param TipoParametro $tipoParametro The TipoParametro entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoParametro $tipoParametro)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_tipoparametro_delete', array('id' => $tipoParametro->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

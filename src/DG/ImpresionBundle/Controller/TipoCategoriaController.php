<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\TipoCategoria;
use DG\ImpresionBundle\Form\TipoCategoriaType;

/**
 * TipoCategoria controller.
 *
 * @Route("/admin/tipocategoria")
 */
class TipoCategoriaController extends Controller
{
    /**
     * Lists all TipoCategoria entities.
     *
     * @Route("/", name="admin_tipocategoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tipoCategorias = $em->getRepository('DGImpresionBundle:TipoCategoria')->findAll();

        return $this->render('tipocategoria/index.html.twig', array(
            'tipoCategorias' => $tipoCategorias,
        ));
    }

    /**
     * Creates a new TipoCategoria entity.
     *
     * @Route("/new", name="admin_tipocategoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tipoCategorium = new TipoCategoria();
        $form = $this->createForm('DG\ImpresionBundle\Form\TipoCategoriaType', $tipoCategorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoCategorium);
            $em->flush();

            return $this->redirectToRoute('admin_tipocategoria_show', array('id' => $tipocategoria->getId()));
        }

        return $this->render('tipocategoria/new.html.twig', array(
            'tipoCategorium' => $tipoCategorium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TipoCategoria entity.
     *
     * @Route("/{id}", name="admin_tipocategoria_show")
     * @Method("GET")
     */
    public function showAction(TipoCategoria $tipoCategorium)
    {
        $deleteForm = $this->createDeleteForm($tipoCategorium);

        return $this->render('tipocategoria/show.html.twig', array(
            'tipoCategorium' => $tipoCategorium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TipoCategoria entity.
     *
     * @Route("/{id}/edit", name="admin_tipocategoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TipoCategoria $tipoCategorium)
    {
        $deleteForm = $this->createDeleteForm($tipoCategorium);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\TipoCategoriaType', $tipoCategorium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipoCategorium);
            $em->flush();

            return $this->redirectToRoute('admin_tipocategoria_edit', array('id' => $tipoCategorium->getId()));
        }

        return $this->render('tipocategoria/edit.html.twig', array(
            'tipoCategorium' => $tipoCategorium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TipoCategoria entity.
     *
     * @Route("/{id}", name="admin_tipocategoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TipoCategoria $tipoCategorium)
    {
        $form = $this->createDeleteForm($tipoCategorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipoCategorium);
            $em->flush();
        }

        return $this->redirectToRoute('admin_tipocategoria_index');
    }

    /**
     * Creates a form to delete a TipoCategoria entity.
     *
     * @param TipoCategoria $tipoCategorium The TipoCategoria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TipoCategoria $tipoCategorium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_tipocategoria_delete', array('id' => $tipoCategorium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

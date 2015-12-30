<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\CategoriaProducto;
use DG\ImpresionBundle\Form\CategoriaProductoType;

/**
 * CategoriaProducto controller.
 *
 * @Route("/categoriaproducto")
 */
class CategoriaProductoController extends Controller
{
    /**
     * Lists all CategoriaProducto entities.
     *
     * @Route("/", name="categoriaproducto_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categoriaProductos = $em->getRepository('DGImpresionBundle:CategoriaProducto')->findAll();

        return $this->render('categoriaproducto/index.html.twig', array(
            'categoriaProductos' => $categoriaProductos,
        ));
    }

    /**
     * Creates a new CategoriaProducto entity.
     *
     * @Route("/new", name="categoriaproducto_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categoriaProducto = new CategoriaProducto();
        $form = $this->createForm('DG\ImpresionBundle\Form\CategoriaProductoType', $categoriaProducto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoriaProducto);
            $em->flush();

            return $this->redirectToRoute('categoriaproducto_show', array('id' => $categoriaproducto->getId()));
        }

        return $this->render('categoriaproducto/new.html.twig', array(
            'categoriaProducto' => $categoriaProducto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CategoriaProducto entity.
     *
     * @Route("/{id}", name="categoriaproducto_show")
     * @Method("GET")
     */
    public function showAction(CategoriaProducto $categoriaProducto)
    {
        $deleteForm = $this->createDeleteForm($categoriaProducto);

        return $this->render('categoriaproducto/show.html.twig', array(
            'categoriaProducto' => $categoriaProducto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CategoriaProducto entity.
     *
     * @Route("/{id}/edit", name="categoriaproducto_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CategoriaProducto $categoriaProducto)
    {
        $deleteForm = $this->createDeleteForm($categoriaProducto);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\CategoriaProductoType', $categoriaProducto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categoriaProducto);
            $em->flush();

            return $this->redirectToRoute('categoriaproducto_edit', array('id' => $categoriaProducto->getId()));
        }

        return $this->render('categoriaproducto/edit.html.twig', array(
            'categoriaProducto' => $categoriaProducto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CategoriaProducto entity.
     *
     * @Route("/{id}", name="categoriaproducto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CategoriaProducto $categoriaProducto)
    {
        $form = $this->createDeleteForm($categoriaProducto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categoriaProducto);
            $em->flush();
        }

        return $this->redirectToRoute('categoriaproducto_index');
    }

    /**
     * Creates a form to delete a CategoriaProducto entity.
     *
     * @param CategoriaProducto $categoriaProducto The CategoriaProducto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CategoriaProducto $categoriaProducto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categoriaproducto_delete', array('id' => $categoriaProducto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Producto;
use DG\ImpresionBundle\Form\ProductoType;

/**
 * Producto controller.
 *
 * @Route("/admin/raw-material")
 */
class ProductoController extends Controller
{
    /**
     * Lists all Producto entities.
     *
     * @Route("/", name="admin_producto_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $productos = $em->getRepository('DGImpresionBundle:Producto')->findBy(array('estado' => 1));
        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render('producto/index.html.twig', array(
            'productos' => $productos,
            'promotion' => $promotion,
        ));
    }

    /**
     * Creates a new Producto entity.
     *
     * @Route("/new", name="admin_producto_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $producto = new Producto();
        $form = $this->createForm('DG\ImpresionBundle\Form\ProductoType', $producto);
        $form->handleRequest($request);
        $producto->setEstado(true);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($producto);
            $em->flush();

//            return $this->redirectToRoute('admin_producto_show', array('id' => $producto->getId()));
            return $this->redirectToRoute('admin_producto_index');
        }

        return $this->render('producto/new.html.twig', array(
            'producto' => $producto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Producto entity.
     *
     * @Route("/{id}", name="admin_producto_show")
     * @Method("GET")
     */
    public function showAction(Producto $producto)
    {
        $deleteForm = $this->createDeleteForm($producto);

        return $this->render('producto/show.html.twig', array(
            'producto' => $producto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Producto entity.
     *
     * @Route("/{id}/edit", name="admin_producto_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Producto $producto)
    {
        $deleteForm = $this->createDeleteForm($producto);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\ProductoType', $producto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($producto);
            $em->flush();

//            return $this->redirectToRoute('admin_producto_edit', array('id' => $producto->getId()));
            return $this->redirectToRoute('admin_producto_index', array('id' => $producto->getId()));
        }

        return $this->render('producto/edit.html.twig', array(
            'producto' => $producto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Producto entity.
     *
     * @Route("/{id}", name="admin_producto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Producto $producto)
    {
        $form = $this->createDeleteForm($producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($producto);
            $em->flush();
        }

        return $this->redirectToRoute('admin_producto_index');
    }

    /**
     * Creates a form to delete a Producto entity.
     *
     * @param Producto $producto The Producto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Producto $producto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_producto_delete', array('id' => $producto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Eliminar un producto 
     *
     * @Route("/delete/{id}", name="delete_producto")
     * @Method("GET")
     */
    public function deleteProductoAction(Producto $producto)
    {
        $em = $this->getDoctrine()->getManager();

        $prod = $em->getRepository('DGImpresionBundle:Producto')->find($producto->getId());
        
        $prod->setEstado(FALSE);

        $em->merge($prod);
        $em->flush();
        
        $productos = $em->getRepository('DGImpresionBundle:Producto')->findBy(array('estado' => 1));
        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render('producto/index.html.twig', array(
            'productos' => $productos,
            'promotion' => $promotion,
        ));
    }
}

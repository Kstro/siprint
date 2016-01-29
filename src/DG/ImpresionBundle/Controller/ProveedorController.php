<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DG\ImpresionBundle\Entity\Proveedor;
use DG\ImpresionBundle\Form\ProveedorType;

/**
 * Proveedor controller.
 *
 * @Route("/admin/providers")
 */
class ProveedorController extends Controller
{
    /**
     * Lists all Proveedor entities.
     *
     * @Route("/", name="admin_proveedor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $proveedors = $em->getRepository('DGImpresionBundle:Proveedor')->findAll();

        $promotion = $this->get('promotion_img')->searchPromotion();
        
        $monto = 100;
        
        $this->get('payment.bridge')->setAmount($monto);
        return $this->render('proveedor/index.html.twig', array(
            'proveedors' => $proveedors,
            'promotion' => $promotion,
        ));
    }

    /**
     * Creates a new Proveedor entity.
     *
     * @Route("/new", name="admin_proveedor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $proveedor = new Proveedor();
        $form = $this->createForm('DG\ImpresionBundle\Form\ProveedorType', $proveedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proveedor);
            $em->flush();

//            return $this->redirectToRoute('admin_proveedor_show', array('id' => $proveedor->getId()));
            return $this->redirectToRoute('admin_proveedor_index');
        }

        return $this->render('proveedor/new.html.twig', array(
            'proveedor' => $proveedor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Proveedor entity.
     *
     * @Route("/{id}", name="admin_proveedor_show")
     * @Method("GET")
     */
    public function showAction(Proveedor $proveedor)
    {
        $deleteForm = $this->createDeleteForm($proveedor);

        return $this->render('proveedor/show.html.twig', array(
            'proveedor' => $proveedor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Proveedor entity.
     *
     * @Route("/{id}/edit", name="admin_proveedor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Proveedor $proveedor)
    {
        $deleteForm = $this->createDeleteForm($proveedor);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\ProveedorType', $proveedor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proveedor);
            $em->flush();

//            return $this->redirectToRoute('admin_proveedor_edit', array('id' => $proveedor->getId()));
            return $this->redirectToRoute('admin_proveedor_index');
        }

        return $this->render('proveedor/edit.html.twig', array(
            'proveedor' => $proveedor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Proveedor entity.
     *
     * @Route("/{id}", name="admin_proveedor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Proveedor $proveedor)
    {
        $form = $this->createDeleteForm($proveedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($proveedor);
            $em->flush();
        }

        return $this->redirectToRoute('admin_proveedor_index');
    }

    /**
     * Creates a form to delete a Proveedor entity.
     *
     * @param Proveedor $proveedor The Proveedor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Proveedor $proveedor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_proveedor_delete', array('id' => $proveedor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    
    
    /**
     * Displays an error page.
     *
     * @Route("/error/pago", name="admin_proveedor_error")
     * @Method("GET")
     */
    public function errorAction()
    {
        $entidad=50;
        return $this->render('proveedor/error.html.twig', array(
            'error'=>'error'
        ));
        //return new Response(json_encode($entidad));
    }
    
}

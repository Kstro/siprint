<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\DetalleOrden;
use DG\ImpresionBundle\Entity\RechazoArchivo;
use DG\ImpresionBundle\Form\DetalleOrdenType;

/**
 * DetalleOrden controller.
 *
 * @Route("/admin/detail-order")
 */
class DetalleOrdenController extends Controller
{
    /**
     * Lists all DetalleOrden entities.
     *
     * @Route("/", name="admin_detalleorden_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $detalleOrdens = $em->getRepository('DGImpresionBundle:DetalleOrden')->findAll();

        return $this->render('detalleorden/index.html.twig', array(
            'detalleOrdens' => $detalleOrdens,
        ));
    }

    /**
     * Creates a new DetalleOrden entity.
     *
     * @Route("/new", name="admin_detalleorden_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $detalleOrden = new DetalleOrden();
        $form = $this->createForm('DG\ImpresionBundle\Form\DetalleOrdenType', $detalleOrden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($detalleOrden);
            $em->flush();

            return $this->redirectToRoute('admin_detalleorden_show', array('id' => $detalleOrden->getId()));
        }

        return $this->render('detalleorden/new.html.twig', array(
            'detalleOrden' => $detalleOrden,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DetalleOrden entity.
     *
     * @Route("/{id}", name="admin_detalleorden_show")
     * @Method("GET")
     */
    public function showAction(DetalleOrden $detalleOrden)
    {
        $em = $this->getDoctrine()->getManager();
        
        $attributes = $em->getRepository('DGImpresionBundle:AtributoProductoOrden')->findBy(array('detalleOrden'   => $detalleOrden
                                                                              ));
        
        
        
        return $this->render('detalleorden/show.html.twig', array(
            'detalleOrden' => $detalleOrden,
            'attributes' => $attributes,
        ));
    }

    /**
     * Displays a form to edit an existing DetalleOrden entity.
     *
     * @Route("/{id}/edit", name="admin_detalleorden_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DetalleOrden $detalleOrden)
    {
        $deleteForm = $this->createDeleteForm($detalleOrden);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\DetalleOrdenType', $detalleOrden);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($detalleOrden);
            $em->flush();

            return $this->redirectToRoute('admin_detalleorden_edit', array('id' => $detalleOrden->getId()));
        }

        return $this->render('detalleorden/edit.html.twig', array(
            'detalleOrden' => $detalleOrden,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a DetalleOrden entity.
     *
     * @Route("/{id}", name="admin_detalleorden_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, DetalleOrden $detalleOrden)
    {
        $form = $this->createDeleteForm($detalleOrden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($detalleOrden);
            $em->flush();
        }

        return $this->redirectToRoute('admin_detalleorden_index');
    }

    /**
     * Creates a form to delete a DetalleOrden entity.
     *
     * @param DetalleOrden $detalleOrden The DetalleOrden entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DetalleOrden $detalleOrden)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_detalleorden_delete', array('id' => $detalleOrden->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
    * Ajax utilizado para cambiar estado del producto a aprobado
    *  
    * @Route("/design/accept/set", name="set_accept_design")
    */
    public function setAcceptDesignAction()
    {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
            $aux = 1;
            
            $id = $this->get('request')->request->get('id');
            //var_dump($id); 
            $em = $this->getDoctrine()->getManager();            
            $det = $em->getRepository('DGImpresionBundle:DetalleOrden')->find($id);
            
            if($det->getEstado() != 'ap' ) {
                $det->setEstado('ap');
                $em->merge($det);
                $em->flush();
            } else {
                $aux = 0;
            }
            
            $response = new JsonResponse(); 
            $response->setData(array(
                           'accept' => $aux
                    )); 
            
            return $response; 
        } else {    
            return new Response('0');              
        }  
    }
    
    /**
    * Ajax utilizado para para cambiar estado del producto a no aprobado y envio de email al cliente
    *  
    * @Route("/design/disapprove/set", name="set_disapprove_design")
    */
    public function setDisapproveDesignAction()
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
            $aux = 0;
            
            $id = $this->get('request')->request->get('id');
            var_dump($id); 
            $em = $this->getDoctrine()->getManager();            
            $det = $em->getRepository('DGImpresionBundle:DetalleOrden')->find($id);
            var_dump($det);
            if($det->getId() == 'df' ) {
                $aux = 1;
            } 
            
            $response = new JsonResponse(); 
            $response->setData(array(
                           'disapprove' => $aux
                    )); 
            
            return $response;  
        } else {    
            return new Response('0');              
        }  
    }
    
    /**
    * Ajax utilizado para buscar el estado del producto 
    *  
    * @Route("/design/accept/search", name="search_accept_design")
    */
    public function setSearchDesignAction()
    {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
        $aux = 0;
            
            $id = $this->get('request')->request->get('id');
            //var_dump($id); 
            $em = $this->getDoctrine()->getManager();            
            $det = $em->getRepository('DGImpresionBundle:DetalleOrden')->find($id);
            
            if($det->getEstado() == 'ap') {
                $aux = 1;
            } else if($det->getEstado() == 'df' ) {
                $aux = 2;
            }
            
            $response = new JsonResponse(); 
            $response->setData(array(
                           'search' => $aux
                    )); 
            
            return $response; 
        } else {    
            return new Response('0');              
        }  
    }
}

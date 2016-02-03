<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Promocion;
use DG\ImpresionBundle\Form\PromocionType;

/**
 * Promocion controller.
 *
 * @Route("/admin/promotions")
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

        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render('promocion/index.html.twig', array(
            'promocions' => $promocions,
            'promotion' => $promotion,
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

            if($promocion->getFile()!=null){
                $path = $this->container->getParameter('photo.promotion');

                $fecha = date('Y-m-d His');
                $extension = $promocion->getFile()->getClientOriginalExtension();
                $nombreArchivo = "promotion_".$fecha.".".$extension;
                $em->persist($promocion);
                $em->flush();
                //var_dump($path.$nombreArchivo);

                $promocion->setImagen($nombreArchivo);
                $promocion->getFile()->move($path,$nombreArchivo);
                $em->persist($promocion);
                $em->flush();
            }
            
            //return $this->redirectToRoute('admin_promocion_show', array('id' => $promocion->getId()));
            return $this->redirectToRoute('admin_promocion_index');
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
            if($promocion->getFile()!=null){
            $path = $this->container->getParameter('photo.promotion');

            $fecha = date('Y-m-d His');
            $extension = $promocion->getFile()->getClientOriginalExtension();
            $nombreArchivo = "promotion_".$fecha.".".$extension;

            //var_dump($path.$nombreArchivo);

            $promocion->setImagen($nombreArchivo);


            $promocion->getFile()->move($path,$nombreArchivo);
        }
            $em = $this->getDoctrine()->getManager();
            $em->persist($promocion);
            $em->flush();

            //return $this->redirectToRoute('admin_promocion_edit', array('id' => $promocion->getId()));
            return $this->redirectToRoute('admin_promocion_index');
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
    
    /**
    * Ajax utilizado para validar la promocion que ha sido ingresada
    *  
    * @Route("/validar", name="valida_promocion")
    */
    public function validaPromocionAction()
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
            $code = $this->get('request')->request->get('promocion');
            $mensaje = '';
            $porcentaje = 0;
            
            $em = $this->getDoctrine()->getManager();            
            $promo = $em->getRepository('DGImpresionBundle:Promocion')->findOneBy(array('codigo' => $code));
            
            if( $promo == NULL && $code != '' ){
                $mensaje = 'Code does not exist';
            } else {
                $porcentaje = $promo->getPorcentaje();
            }
            
            $response = new JsonResponse();
            $response->setData(array(
                                'msj' => $mensaje,
                                'porcentaje' => $porcentaje
                            ));
            return $response; 
        } else {    
            return new Response('0');              
        }  
        
    }
}

<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Direccion;
use DG\ImpresionBundle\Form\DireccionType;

/**
 * Direccion controller.
 *
 * @Route("/admin/address-book")
 */
class DireccionController extends Controller
{
    /**
     * Lists all Direccion entities.
     *
     * @Route("/", name="admin_address_book_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuario= $this->get('security.token_storage')->getToken()->getUser();
        
        $dql = "SELECT d FROM DGImpresionBundle:Direccion d "
                . "WHERE d.usuario=:usuario "
                . "ORDER BY d.defaultDir DESC, d.name";
        
        $direccions = $em->createQuery($dql)
                   ->setParameter('usuario', $usuario)
                   ->getResult();

        return $this->render('direccion/index.html.twig', array(
            'direccions' => $direccions,
        ));
    }

    /**
     * Creates a new Direccion entity.
     *
     * @Route("/new", name="admin_address_book_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $usuario= $this->get('security.token_storage')->getToken()->getUser();
        
        $direccion = new Direccion();
        $form = $this->createForm('DG\ImpresionBundle\Form\DireccionType', $direccion);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $direccion->setUsuario($usuario);
            $em = $this->getDoctrine()->getManager();

            if($direccion->getDefaultDir() == TRUE){
                $dql = "SELECT d FROM DGImpresionBundle:Direccion d "
                        . "WHERE d.defaultDir=:default AND d.usuario=:usuario";

                $dir = $em->createQuery($dql)
                          ->setParameter('default', 1)
                          ->setParameter('usuario', $usuario)
                          ->getResult();
                
                if(!empty($dir)){   
                    $dir[0]->setDefaultDir(0);
                    $em->merge($dir[0]);
                    $em->flush();
                }    
            }
            $em->persist($direccion);
            $em->flush();

            //return $this->redirectToRoute('admin_address_book_show', array('id' => $direccion->getId()));
            return $this->redirectToRoute('admin_address_book_index');
        }

        return $this->render('direccion/new.html.twig', array(
            'direccion' => $direccion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Direccion entity.
     *
     * @Route("/{id}", name="admin_address_book_show")
     * @Method("GET")
     */
    public function showAction(Direccion $direccion)
    {
        $deleteForm = $this->createDeleteForm($direccion);

        return $this->render('direccion/show.html.twig', array(
            'direccion' => $direccion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Direccion entity.
     *
     * @Route("/{id}/edit", name="admin_address_book_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Direccion $direccion)
    {
        
        
        $deleteForm = $this->createDeleteForm($direccion);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\DireccionType', $direccion);
        $editForm->handleRequest($request);
        
        

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $usuario= $this->get('security.token_storage')->getToken()->getUser();
            $direccion->setUsuario($usuario);
            
            $em = $this->getDoctrine()->getManager();
            if($direccion->getDefaultDir() == TRUE){
                $dql = "SELECT d FROM DGImpresionBundle:Direccion d "
                        . "WHERE d.defaultDir=:default AND d.usuario=:usuario";

                $dir = $em->createQuery($dql)
                           ->setParameter('default', 1)
                        ->setParameter('usuario', $usuario)
                           ->getResult();
                $dir[0]->setDefaultDir(0);
                $em->merge($dir[0]);
                $em->flush();
            }
            $em->persist($direccion);
            $em->flush();

            //return $this->redirectToRoute('admin_address_book_edit', array('id' => $direccion->getId()));
            return $this->redirectToRoute('admin_address_book_index');
        }

        return $this->render('direccion/edit.html.twig', array(
            'direccion' => $direccion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Direccion entity.
     *
     * @Route("/{id}", name="admin_address_book_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Direccion $direccion)
    {
        $form = $this->createDeleteForm($direccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($direccion);
            $em->flush();
        }

        return $this->redirectToRoute('admin_address_book_index');
    }

    /**
     * Creates a form to delete a Direccion entity.
     *
     * @param Direccion $direccion The Direccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Direccion $direccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_address_book_delete', array('id' => $direccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

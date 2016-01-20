<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Orden;
use DG\ImpresionBundle\Form\OrdenType;

/**
 * Orden controller.
 *
 * @Route("/")
 */
class OrdenController extends Controller
{
    /**
     * Lists all Orden entities.
     *
     * @Route("/orders", name="orden_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ordens = $em->getRepository('DGImpresionBundle:Orden')->findAll();

        return $this->render('orden/index.html.twig', array(
            'ordens' => $ordens,
        ));
    }

    /**
     * Creates a new Orden entity.
     *
     * @Route("/orders/new", name="orden_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $orden = new Orden();
        $form = $this->createForm('DG\ImpresionBundle\Form\OrdenType', $orden);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($orden);
            $em->flush();

            return $this->redirectToRoute('orden_show', array('id' => $orden->getId()));
        }

        return $this->render('orden/new.html.twig', array(
            'orden' => $orden,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Orden entity.
     *
     * @Route("/admin/shopping-cart", name="orden_show")
     * @Method("GET")
     */
    public function showAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        
        $cart = $em->getRepository('DGImpresionBundle:Orden')->findOneBy(array('estado'   => 'ca',
                                                                               'usuario'  => $usuario
                                                                              ));

        $products = $em->getRepository('DGImpresionBundle:DetalleOrden')->findBy(array('orden'   => $cart
                                                                              ));
        
                                                                              var_dump($products);
        
        return $this->render('orden/show.html.twig', array(
            'orden' => $cart,
            'products' => $products,
        ));
    }

    /**
     * Displays a form to edit an existing Orden entity.
     *
     * @Route("/admin/orders/{id}/edit", name="orden_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Orden $orden)
    {
        $deleteForm = $this->createDeleteForm($orden);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\OrdenType', $orden);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($orden);
            $em->flush();

            return $this->redirectToRoute('orden_edit', array('id' => $orden->getId()));
        }

        return $this->render('orden/edit.html.twig', array(
            'orden' => $orden,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Orden entity.
     *
     * @Route("/admin/orders/{id}", name="orden_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Orden $orden)
    {
        $form = $this->createDeleteForm($orden);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($orden);
            $em->flush();
        }

        return $this->redirectToRoute('orden_index');
    }

    /**
     * Creates a form to delete a Orden entity.
     *
     * @param Orden $orden The Orden entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Orden $orden)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orden_delete', array('id' => $orden->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Creates a new Order entity.
     *
     * @Route("/admin/create", name="admin_carrito_order")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $orden = new Orden();
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        
        $direccionEnvio = $em->getRepository('DGImpresionBundle:Direccion')->findOneBy(array('defaultDir' => TRUE,
                                                                                          'usuario'    => $usuario
                                                                                          ));
        
        $cart = $em->getRepository('DGImpresionBundle:Orden')->findOneBy(array('estado'   => 'ca',
                                                                               'usuario'  => $usuario
                                                                              ));
//                                                                              var_dump($cart);
//                                                                              die();
                                                                              
        $parameters = $request->request->all();
        
        if($cart == NULL) {
            $orden->setUsuario($usuario);
            $orden->setDireccionEnvio($direccionEnvio);
            $orden->setFechaAccion(new \DateTime ('now'));
            $orden->setEstado('ca');
            $em->persist($orden);
            $em->flush();
        }
        else {
            $orden = $cart;
        }
        
        $path = $this->container->getParameter('photo.promotion');
        $nombre_archivo = strtolower($_FILES["file-design"]["name"]);
        $aux = explode('.', $nombre_archivo);
        $extension = end($aux);
        $archivo_subir = 'Producto'.'_'.date("d-m-Y_H-i-s").'.'.$extension;
        //var_dump($direccionEnvio);
        
        $detalleorden = new \DG\ImpresionBundle\Entity\DetalleOrden();
        
        $product = $em->getRepository('DGImpresionBundle:Categoria')->find($parameters['order-now']);
        $detalleorden->setArchivo($archivo_subir);
        move_uploaded_file($_FILES['file-design']['tmp_name'], $path.$archivo_subir);

        $detalleorden->setCategoria($product);
        $detalleorden->setOrden($orden);
        
        $em->persist($detalleorden);
        $em->flush();
       
        
        $types = $em->getRepository('DGImpresionBundle:Categoria')->findBy(array('categoria' => NULL));
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NOT NULL ";
        
        $categorias = $em->createQuery($dql)
                   ->getResult();
        
        return $this->render('categoria/productslist.html.twig', array(
            'types' => $types,
            'categorias' => $categorias,
            'registro'=>null
        ));
    }
}

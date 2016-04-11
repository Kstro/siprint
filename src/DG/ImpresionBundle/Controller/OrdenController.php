<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Orden;
use DG\ImpresionBundle\Entity\Cliente;
use DG\ImpresionBundle\Form\OrdenType;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\ParameterBag;

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
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $ordens = $em->getRepository('DGImpresionBundle:Orden')->findBy(array('usuario'=>$user));
        
        $dql = "SELECT o FROM DGImpresionBundle:Orden o "
                . "WHERE o.usuario=:usuario AND o.estado <> 'ca' ORDER BY o.id DESC";
        
        $cart = $em->createQuery($dql)
                ->setParameters(array('usuario'=>$user->getId()))
                ->getResult();
        
        //$mensaje = $request->request->get('mensaje');
        if($request->query->get('mensaje')!=''){
            $mensaje = "Transacción exitosa";
        }
        else{
            $mensaje = -1;
        }
        
        
//        $cart = $em->getRepository('DGImpresionBundle:Orden')->findBy(array('estado'   => 'ca',
//                                                                               'usuario'  => $user
//                                                                              ));

        $products = $em->getRepository('DGImpresionBundle:DetalleOrden')->findAll();
        $promotion = $this->get('promotion_img')->searchPromotion();
        //var_dump($products);
        
        //var_dump($products[0]->getAtributoProductoOrden()[0]->getDetalleParametro());        
        //var_dump($cart);
        return $this->render('orden/index.html.twig', array(
            'orden' => $cart,
            'products' => $products,
            'usuario' => $user,
            'promotion' => $promotion,
            'mensaje'=>$mensaje,
        ));
        //var_dump($ordens);
//        return $this->render('orden/index.html.twig', array(
//            'ordens' => $ordens,
//        ));
    }

    /**
     * Lists all Orden entities.
     *
     * @Route("/admin/orders", name="admin_view_orders_")
     * @Method("GET")
     */
    public function viewOrdersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $dql = "SELECT o FROM DGImpresionBundle:Orden o "
                . "WHERE o.estado <> 'ca' ORDER BY o.id DESC";
        
        $cart = $em->createQuery($dql)
                ->getResult();
        
        $products = $em->getRepository('DGImpresionBundle:DetalleOrden')->findAll();
        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render('orden/view_order.html.twig', array(
            'orders' => $cart,
            'products' => $products,
            'usuario' => $user,
            'promotion' => $promotion,
        ));

    }
    
    /**
     * Creates a new Orden entity.
     *
     * @Route("/admin/sale/register", name="admin_register_sale")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        $promotion = $this->get('promotion_img')->searchPromotion();
        
        $em = $this->getDoctrine()->getManager();
        
        $orden = new Orden();
        $form = $this->createForm('DG\ImpresionBundle\Form\OrdenType', $orden);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $parameters = $request->request->all();
    
            if($parameters['code-promo'] != 0){
                $promocion = $em->getRepository('DGImpresionBundle:Promocion')->find($parameters['code-promo']);
                $orden->setPromocion($promocion);
            }
            
            // Si se va a registrar a un cliente existente a la venta
            if($parameters['customer'] == 'cu-exist'){
                $cliente = $em->getRepository('DGImpresionBundle:Cliente')->find($parameters['orden']['cliente']);
                $orden->setCliente($cliente);
                
                // Si se va a registrar una direccion existente del cliente
                if(isset($parameters['address'])){
                    if($parameters['address'] == 'ad-exist'){ 
                        $direccion = $em->getRepository('DGImpresionBundle:Direccion')->find($parameters['orden']['direccionEnvio']);
                        $orden->setDireccionEnvio($direccion);

                    // Si se va a registrar una nueva direccion del cliente
                    } else {
                        $direccion = new \DG\ImpresionBundle\Entity\Direccion();

                        $direccion->setName($parameters['direccion']['name']);
                        $direccion->setLinea1($parameters['direccion']['linea1']);
                        $direccion->setLinea2($parameters['direccion']['linea2']);
                        $direccion->setCity($parameters['direccion']['city']);
                        $direccion->setState($parameters['direccion']['state']);
                        $direccion->setCountry($parameters['direccion']['country']);
                        $direccion->setPhoneNumber($parameters['direccion']['phoneNumber']);
                        $direccion->setZipCode($parameters['direccion']['zipCode']);
                        $direccion->setSecurityAccessCode($parameters['direccion']['securityAccessCode']);
                        $direccion->setDefaultDir(1);

                        $em->persist($direccion);
                        $em->flush();
                        $orden->setDireccionEnvio($direccion);
                    }
                }
            // Si se va a registrar un nuevo cliente a la venta    
            } else {
                $persona = new \DG\ImpresionBundle\Entity\Persona();
                $persona->setNombres($parameters['cliente']['first_name']);
                $persona->setApellidos($parameters['cliente']['last_name']);
                $persona->setTelefono($parameters['cliente']['phone']);
                $persona->setEstado(1);
                $em->persist($persona);
                $em->flush();
                
                $cliente = new \DG\ImpresionBundle\Entity\Cliente();
                $cliente->setPersona($persona);
                $cliente->setEstado(1);
                $cliente->setTelefono($parameters['cliente']['phone-2']);
                $cliente->setEmail($parameters['cliente']['email']);
                $cliente->setOtro($parameters['cliente']['other']);
                $em->persist($cliente);
                $em->flush();
                
                $orden->setCliente($cliente);
                
                if(isset($direccion)){
                    $em->persist($direccion);
                    $em->flush();
                    $orden->setDireccionEnvio($direccion);
                
                    $direccion = new \DG\ImpresionBundle\Entity\Direccion();
                    $direccion->setName($parameters['direccion']['name']);
                    $direccion->setLinea1($parameters['direccion']['linea1']);
                    $direccion->setLinea2($parameters['direccion']['linea2']);
                    $direccion->setCity($parameters['direccion']['city']);
                    $direccion->setState($parameters['direccion']['state']);
                    $direccion->setCountry($parameters['direccion']['country']);
                    $direccion->setPhoneNumber($parameters['direccion']['phoneNumber']);
                    $direccion->setZipCode($parameters['direccion']['zipCode']);
                    $direccion->setSecurityAccessCode($parameters['direccion']['securityAccessCode']);
                    $direccion->setDefaultDir(1);

                    $em->persist($direccion);
                    $em->flush();
                    $orden->setDireccionEnvio($direccion);
                }
            }
            $orden->setReembolso(0);
            $orden->setFechaPago(new \DateTime ('now'));
            $orden->setFechaAccion(new \DateTime ('now'));
            $orden->setEstado('sas');
            
            if($parameters['code-promo'] != ''){
                $promocion = $em->getRepository('DGImpresionBundle:Promocion')->find($parameters['code-promo']);
                
                if($promocion != NULL) { 
                    $orden->setPorcentaje($promocion->getPorcentaje());
                    $orden->setCodigoUsado($promocion->getCodigo());
                } else {
                    $orden->setPorcentaje(0);
                    $orden->setCodigoUsado('-');
                }
                //$orden->setPromocion($promocion);
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($orden);
            $em->flush();
            
            foreach($parameters['selectDesigns'] as $key => $prod){
                $detalleorden = new \DG\ImpresionBundle\Entity\DetalleOrden();

                $product = $em->getRepository('DGImpresionBundle:Categoria')->find($prod);
                $detalleorden->setArchivo($parameters['file-design'][$key]);
                //move_uploaded_file($_FILES['file-design']['tmp_name'], $path.$archivo_subir);

                $detalleorden->setEstado('ad');
                $detalleorden->setCategoria($product);
                $detalleorden->setOrden($orden);
                
                if($product->getCategoria()->getId() != 38){
                    $tax = $em->getRepository('DGImpresionBundle:Tax')->find(1);
                    $valor_tax = $tax->getValor();
                    $detalleorden->setTax($valor_tax);
                } else {
                    $detalleorden->setTax(0);
                }  
                
                $em->persist($detalleorden);
                $em->flush();
                $total = 0;
                
                foreach($parameters as $i => $p){
                    $atributo = new \DG\ImpresionBundle\Entity\AtributoProductoOrden();

                    $val = explode("-", $i);
                    
                    if($val[0] == 'attributes' && $val[1] == $key ) {
                        $opcion = $em->getRepository('DGImpresionBundle:OpcionProducto')->find($p);
                        
                        $atributo->setOpcionProducto($opcion);
                        $atributo->setDetalleOrden($detalleorden);
                        $em->persist($atributo);
                        $em->flush();

                        $total+=$atributo->getOpcionProducto()->getCosto();
                        
                    }    
                }
                //var_dump($total);
                $detalleorden->setMonto($total);
                $em->merge($detalleorden);
                $em->flush();
            }
            //die();    
            return $this->redirectToRoute('admin_store_sale');
        }

        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NOT NULL AND p.estado = 1 AND p.categoria <> 1 ";
        
        $categorias = $em->createQuery($dql)
                   ->getResult();
        
        $promocions = $em->getRepository('DGImpresionBundle:Promocion')->findAll();
        $tax = $em->getRepository('DGImpresionBundle:Tax')->find(1);
        
        return $this->render('orden/new.html.twig', array(
            'orden' => $orden,
            'categorias' => $categorias,
            'promociones' => $promocions,
            'form' => $form->createView(),
            'promotion' => $promotion,
            'tax' => $tax,
        ));
    }

    /**
     * Finds and displays a Orden entity.
     *
     * @Route("/shopping-cart", name="orden_show")
     * @Method("GET")
     */
    public function showAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        $authorizationChecker = $this->get('security.authorization_checker');
        
        if (false === $authorizationChecker->isGranted('ROLE_USER')) {
            $cart = $em->getRepository('DGImpresionBundle:Orden')->findOneBy(array('estado'   => 'ca',
                                                                                    'cookie'  => $_COOKIE['expressionsPrint']
                                                                                   ));
        } else {
            $cart = $em->getRepository('DGImpresionBundle:Orden')->findOneBy(array('estado'   => 'ca',
                                                                                    'usuario'  => $usuario
                                                                                   ));
            
//            $dql = "SELECT ca "
//                    . "FROM DGImpresionBundle:DetalleOrden do "
//                    . "INNER JOIN do.categoria ca "
//                    . "INNER JOIN do.orden or "
//                    . "WHERE or.estado = :estado "
//                    . "AND or.usuario = :usuario ";

//            $cart = $em->createQuery($dql)
//                       ->setParameters(array('estado' => 'ca'))
//                       ->setParameters(array('usuario' => $usuario))
//                       ->getResult();   
        }
        
        
        
        $noOrden=false;
        if($cart==null){
            $noOrden=true;
        }
        $products = $em->getRepository('DGImpresionBundle:DetalleOrden')->findBy(array('orden'   => $cart
                                                                              ));
        
        $promotion = $this->get('promotion_img')->searchPromotion();  
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NULL "
                . "AND p.id <> :tshirt "
                . "AND p.estado = 1 ";
        
        $types = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NOT NULL AND p.estado = 1 ";
        
        $categorias = $em->createQuery($dql)
                   ->getResult();
        
        $tax = $em->getRepository('DGImpresionBundle:Tax')->find(1);
        
        return $this->render('orden/show.html.twig', array(
            'ord' => $cart,
            'products' => $products,
            'promotion' => $promotion,
            'types' => $types,
            'categorias' => $categorias,
            'tax' => $tax,
            'registro'=>null
        ));
    }
    
    /**
     * Finds and displays a Orden entity.
     *
     * @Route("/admin/store-sale", name="admin_store_sale")
     * @Method("GET")
     */
    public function storeSaleAction()
    {
        $orden = new Orden();
        $form = $this->createForm('DG\ImpresionBundle\Form\OrdenType', $orden);
        
        $em = $this->getDoctrine()->getManager();
        
        $sales = $em->getRepository('DGImpresionBundle:Orden')->findBy(array('estado'   => 'sas'));
        //var_dump($sales);
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        $promotion = $this->get('promotion_img')->searchPromotion();
        $tax = $em->getRepository('DGImpresionBundle:Tax')->find(1);
        
        return $this->render('orden/store_sale.html.twig', array(
            'orden' => $orden,
            'sales' => $sales,
            'form' => $form->createView(),
            'usuario' => $usuario,
            'promotion' => $promotion,
            'tax' => $tax,
        ));
    }
    
    /**
     * Finds and displays a Orden entity.
     *
     * @Route("/admin/order/{id}", name="admin_orden_show")
     * @Method("GET")
     */
    public function showOrderAction(Orden $orden)
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('DGImpresionBundle:DetalleOrden')->findBy(array('orden' => $orden,
                                                                                ));
        
        $promotion = $this->get('promotion_img')->searchPromotion();
        $tax = $em->getRepository('DGImpresionBundle:Tax')->find(1);
        
        return $this->render('orden/show_order.html.twig', array(
            'promotion' => $promotion,
            'ord' => $orden,
            'products' => $products,
            'tax' => $tax,
        ));
    }
    
    
    
    
    /**
     * Finds and displays a Orden entity.
     *
     * @Route("/admin/order/refund/{id}", name="admin_orden_refund")
     * @Method("GET")
     */
    public function refundAction(Orden $orden)
    {
        $em = $this->getDoctrine()->getManager();
        $detalleOrden = $em->getRepository('DGImpresionBundle:DetalleOrden')->findBy(array('orden' => $orden,
                                                                                ));
        $monto = 0;
        foreach($detalleOrden as $row){
            $monto = $monto+ $row->getMonto();
        }
        //var_dump($monto);
        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render('orden/refund_order.html.twig', array(
            'promotion' => $promotion,
            'totalOrder' => $monto,
            'order' => $orden->getId(),
        ));
    }
    
    
    
    
    /**
     * Finds and displays a Orden entity.
     *
     * @Route("/admin/order/refund/done", name="admin_orden_refund_done")
     * @Method("POST")
     */
    public function refunddoneAction(Request $request)
    {
        //var_dump($request->getMethod());
        $em = $this->getDoctrine()->getManager();
        $orden = $request->get('orderid');
        $detalleOrden = $em->getRepository('DGImpresionBundle:Orden')->find($orden);
        
        
        
        
        
        if ($request->getMethod()=="POST") {
            $em = $this->getDoctrine()->getManager();
            $refundAmount = $request->get('refundAmount');
            //echo $refundAmount+0;
            //die();
            //$refundAmount = $refundAmount+0.0;
            $m = $refundAmount;
            //var_dump($m);
            $detalleOrden->setReembolso($m);
            $em->persist($detalleOrden);
            $em->flush();
        }
        else{
            
        }
        //var_dump($orden);
        //echo "fin";
        //die();
        return $this->redirectToRoute('admin_view_orders_');
        //var_dump($monto);
//        $promotion = $this->get('promotion_img')->searchPromotion();
//        
//        return $this->render('orden/refund_order.html.twig', array(
//            'promotion' => $promotion,
//            'totalOrder' => $monto,
//            'order' => $orden->getId(),
//        ));
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
     * @Route("/admin/order/{id}", name="orden_delete")
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
     * @Route("/create", name="admin_carrito_order")
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
        
        $parameters = $request->request->all();

        
        $authorizationChecker = $this->get('security.authorization_checker'); 
        $em = $this->getDoctrine()->getManager();            

        $param = array();
        if (false === $authorizationChecker->isGranted('ROLE_USER')) {
            if(!isset($_COOKIE['expressionsPrint'])){
                $val = 1;
                $valorCookie = $em->getRepository('DGImpresionBundle:Cookie')->findBy(array(),array('valor' => 'DESC'));

                if(isset($valorCookie[0])){
                    $val = $valorCookie[0]->getValor();
                    $val++;
                }

                $cart = $em->getRepository('DGImpresionBundle:Orden')->findOneBy(array('estado'   => 'ca',
                                                                                    'cookie'  => $val
                                                                                   ));

                if($usuario != 'anon.') {
                    $orden->setUsuario($usuario);
                                    }

                if($direccionEnvio != NULL) {
                    $orden->setDireccionEnvio($direccionEnvio);
                } else {
                    $orden->setDireccionEnvio(NULL);
                }

                $orden->setCookie($val);
                $galleta = new \DG\ImpresionBundle\Entity\Cookie();
                $galleta->setNombre('expressionsPrint');
                $galleta->setValor($val);
                $em->persist($galleta);
                $em->flush();
                setcookie('expressionsPrint', $val, time()+3600, "/");

                $orden->setFechaAccion(new \DateTime ('now'));
                $orden->setEstado('ca');
                $em->persist($orden);
                $em->flush();

            }else {
                $orden = $em->getRepository('DGImpresionBundle:Orden')->findOneBy(array('estado'   => 'ca',
                                                                                    'cookie'  => $_COOKIE['expressionsPrint']
                                                                                   ));
            }
        } else {
            $cart = $em->getRepository('DGImpresionBundle:Orden')->findOneBy(array('estado'   => 'ca',
                                                                                    'usuario'  => $usuario
                                                                                   ));
            
            if($cart == NULL){
                $orden = $orden->setUsuario($usuario);
                
                $cliente = $em->getRepository('DGImpresionBundle:Cliente')->findOneBy(array('persona' => $usuario->getPersona()));
                $orden->setCliente($cliente);
                
                if($direccionEnvio != NULL) {
                    $orden->setDireccionEnvio($direccionEnvio);
                } else {
                    $orden->setDireccionEnvio(NULL);
                }
                
                $orden->setFechaAccion(new \DateTime ('now'));
                $orden->setEstado('ca');
                $em->persist($orden);
                $em->flush();
            } else {
                $orden = $cart;
            }
        }
        
//        if($cart == NULL) {
//            
//            $cookie = new Cookie('expressionsPrint', $val);
//            $response = new Response();
//            $response->headers->setCookie($cookie);
//            $response->send(); 
//            
//        }
//        else {
//            $orden = $cart;
//        }
        //var_dump($orden);
        $detalleorden = new \DG\ImpresionBundle\Entity\DetalleOrden();
        $product = $em->getRepository('DGImpresionBundle:Categoria')->find($parameters['orden-now']);
        $path = $this->container->getParameter('photo.promotion');
        
        if(isset($_FILES["file-design"]["name"])){
            $nombre_archivo = strtolower($_FILES["file-design"]["name"]);
            $aux = explode('.', $nombre_archivo);
            $extension = end($aux);
            $archivo_subir = 'Producto'.'_'.date("d-m-Y_H-i-s").'.'.$extension;

            $detalleorden->setArchivo($archivo_subir);
            move_uploaded_file($_FILES['file-design']['tmp_name'], $path.$archivo_subir);
        }    

        $detalleorden->setEstado('ad');
        $detalleorden->setCategoria($product);
        $detalleorden->setOrden($orden);
        
        if($product->getCategoria()->getId() != 38){
            $tax = $em->getRepository('DGImpresionBundle:Tax')->find(1);
            $valor_tax = $tax->getValor();
            $detalleorden->setTax($valor_tax);
        } else {
            $detalleorden->setTax(0);
        }    
            
        $em->persist($detalleorden);
        $em->flush();
        $total = 0;
        
        foreach($parameters as $key => $p){
            $atributo = new \DG\ImpresionBundle\Entity\AtributoProductoOrden();
            
            $val = explode("-", $key);
            if($val[0] == 'attributes') {
                $opcion = $em->getRepository('DGImpresionBundle:OpcionProducto')->find($p);
                
                $atributo->setOpcionProducto($opcion);
                $atributo->setDetalleOrden($detalleorden);
                $em->persist($atributo);
                $em->flush();
               
                $total+=$atributo->getOpcionProducto()->getCosto();
            }    
        }
                                           
        $detalleorden->setMonto($total);
        $em->merge($detalleorden);
        $em->flush();
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NULL "
                . "AND p.id <> :tshirt "
                . "AND p.estado = 1 ";
        
        $types = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();

//        $dql = "SELECT p "
//                . "FROM DGImpresionBundle:Categoria p "
//                . "WHERE p.categoria IS NOT NULL "
//                . "AND p.estado = 1 ";
//        
//        $categorias = $em->createQuery($dql)
//                   ->getResult();

        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "INNER JOIN p.categoria cat "
                . "WHERE p.categoria IS NOT NULL "
                . "AND p.estado = 1 AND cat.estado = 1 AND p.categoria <> :tshirt ";
        
        $categorias = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();
        
//        $dql = "SELECT p "
//                . "FROM DGImpresionBundle:Categoria p "
//                . "WHERE p.categoria IS NOT NULL ";
//        
//        $categorias = $em->createQuery($dql)
//                   ->getResult();
        
        $promotion = $this->get('promotion_img')->searchPromotion();
        
//        $carrito = $em->getRepository('DGImpresionBundle:Orden')->findOneBy(array('estado'   => 'ca',
//                                                                                'cookie'  => $_COOKIE['expressionsPrint']
//                                                                               ));
        
//        $products = $em->getRepository('DGImpresionBundle:DetalleOrden')->findBy(array('orden'   => $carrito
//                                                                              ));

        return $this->render('categoria/productslist.html.twig', array(
            'types' => $types,
            'categorias' => $categorias,
            'promotion' => $promotion,
            'registro'=>null
        ));
        
//        return $this->render('orden/show.html.twig', array(
//            'ord' => $carrito,
//            'products' => $products,
//            'promotion' => $promotion,
//            'types' => $types,
//            'categorias' => $categorias,
//            'registro'=>null
//        ));
    }
    
    /**
    * Ajax utilizado para buscar informacion del producto
    *  
    * @Route("/show-cart", name="show-cart")
    */
    public function showCartAction()
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
            $usuario = $this->get('security.token_storage')->getToken()->getUser();
            $authorizationChecker = $this->get('security.authorization_checker'); 
            $em = $this->getDoctrine()->getManager();            
            
            $param = array();
            if (false === $authorizationChecker->isGranted('ROLE_USER')) {
                $rsm = new ResultSetMapping();
                $sql = "select ca.nombre as product, "
                        . "ca.imagen as image, "
                        . "do.monto as monto "
                        . "from orden ord "
                        . "inner join detalle_orden do on ord.id = do.orden "
                        . "inner join categoria ca on do.categoria = ca.id "
                        . "where ord.estado = 'ca'"
                        . "and ord.cookie = :cookie ";

                $rsm->addScalarResult('product','product');
                $rsm->addScalarResult('image','image');
                $rsm->addScalarResult('monto','monto');

                $query = $em->createNativeQuery($sql, $rsm);

                if(isset($_COOKIE['expressionsPrint'])){
                    $query->setParameters(array('cookie'=>$_COOKIE['expressionsPrint']));
                } 
                else {
                    $query->setParameters(array('cookie' => -1));
                }

                $param = $query->getResult();
            } else {
                $rsm = new ResultSetMapping();
                $sql = "select ca.nombre as product, "
                        . "ca.imagen as image, "
                        . "do.monto as monto "
                        . "from orden ord "
                        . "inner join detalle_orden do on ord.id = do.orden "
                        . "inner join categoria ca on do.categoria = ca.id "
                        . "where ord.estado = 'ca'"
                        . "and ord.usuario = :usuario ";

                $rsm->addScalarResult('product','product');
                $rsm->addScalarResult('image','image');
                $rsm->addScalarResult('monto','monto');

                $query = $em->createNativeQuery($sql, $rsm);
                $query->setParameters(array('usuario'=>$usuario->getId()));
                $param = $query->getResult();                
            }
            
            $response = new JsonResponse();
            $response->setData(array(
                                'cart' => $param
                            )); 
            
            return $response; 
        } else {    
            return new Response('0');              
        }  
    }
    
    //Realiza el checkout de la orden
    /**
     * Displays a form to edit an existing Orden entity.
     *
     * @Route("/admin/orders/{orden}/edit/checkout", name="orden_checkout")
     * @Method({"GET"})
     */
    public function checkoutAction(Request $request, $orden)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $authorizationChecker = $this->get('security.authorization_checker');
        
        $em = $this->getDoctrine()->getManager();
        $registro = $em->getRepository('DGImpresionBundle:Orden')->find($orden);
        
        $direcciones = $em->getRepository('DGImpresionBundle:Direccion')->findBy(array('usuario'=>$user->getId()),array('defaultDir' => 'DESC'));
        $tarjetas = $em->getRepository('DGImpresionBundle:Tarjeta')->findBy(array('usuario'=>$user->getId()));
        
        if(isset($_COOKIE['expressionsPrint'])){
            if(true === $authorizationChecker->isGranted('ROLE_USER')){
                $user_cart = $em->getRepository('DGImpresionBundle:Orden')->findOneBy(array('estado'   => 'ca',
                                                                                    'usuario'  => $user
                                                                                   ));
            
                                                                                   
                
                if($user_cart == NULL){
                    $registro->setUsuario($user);

                    $cliente = $em->getRepository('DGImpresionBundle:Cliente')->findOneBy(array('persona' => $user->getPersona()));
                    $registro->setCliente($cliente);
                    $em->merge($registro);
                    $em->flush();
                
                } else {
                    $products = $em->getRepository('DGImpresionBundle:DetalleOrden')->findBy(array('orden' => $registro));
                    $registro->setEstado('zz');

                    foreach ($products as $key => $product) {
                        $product->setOrden($user_cart); 
                        $em->merge($product);
                        $em->flush();
                    }
                    
                    $registro = $user_cart;
                } 
            }
            
            //Destruccion de la cookie
            unset($_COOKIE['expressionsPrint']);
            setcookie('expressionsPrint', "", time()-3600, "/");
        }    
        
        $totalOrden = 0;
        foreach ($registro->getDetalleOrden() as $row){
            $totalOrden=$totalOrden+$row->getMonto();
        }
        
        $products = $em->getRepository('DGImpresionBundle:DetalleOrden')->findBy(array('orden' => $orden,
                                                                                ));
        
        $tax = $em->getRepository('DGImpresionBundle:Tax')->find(1);
        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render('orden/checkout.html.twig', array(
            'ord' => $registro,
            'ordenId'=>$orden,
            'tarjetas'=>$tarjetas,
            'direcciones' => $direcciones,
            'totalOrden' => $totalOrden,
            'products' => $products,
            'tax' => $tax,
            'promotion' => $promotion,
        ));
    }
    
    
    
    
    
    /**
     * Displays a form to edit an existing Orden entity.
     *
     * @Route("/orders/delete/deletedetalle", name="orden_delete")
     */
    public function deleteDetalleAction()
    {
        
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        //var_dump($isAjax);
        $response = new JsonResponse();
        //if($isAjax){
            $detalleId = $this->get('request')->request->get('detalleId');
            $ordenId = $this->get('request')->request->get('ordenId');
            //var_dump($id);
            $em = $this->getDoctrine()->getManager();
            $detalleOrden = $em->getRepository('DGImpresionBundle:DetalleOrden')->find($detalleId);
            
            
            //var_dump($detalleOrden);
            $em->remove($detalleOrden);
            //die();
            $em->flush();
            
            $detalleOrdenRecalc = $em->getRepository('DGImpresionBundle:DetalleOrden')->findBy(array('orden'=>$ordenId));
            
            //var_dump(count($detalleOrdenRecalc));
            $total=0;
            if(count($detalleOrdenRecalc)!=0){
                foreach ($detalleOrdenRecalc as $row){
                    $total=$total+$row->getMonto();
                }
            }
            //var_dump($total);
            $response->setData(array(
                            'flag' => 0,
                            'monto'=>$total,
                    ));    
            return $response; 
        /*} else {    
            $response->setData(array(
                           'flag' => 1
                    ));
            return $response; 
            
        }*/
        
        
        
        
    }
    
    
    
    /**
     * @Route("/orden/get/payment/address", name="get_pago")
     */
    public function datosTarjetaAction(Request $request) {
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $direccionId = $this->get('request')->request->get('direccionId');
        $tarjetaId = $this->get('request')->request->get('tarjetaId');
        
        //var_dump($direccionId);
        //var_dump($tarjetaId);
        $response = new JsonResponse();
        $address = $em->getRepository('DGImpresionBundle:Direccion')->find($direccionId);
        $card = $em->getRepository('DGImpresionBundle:Tarjeta')->find($tarjetaId);
        
        
        //var_dump($card->getExpiracion()->format('m-Y'));
//        if(count($address)!=0 && count($card)!=0){
        if(count($card)!=0){
            
            $numero = $card->getNumero();
            $cvc = $card->getCvc();
            $expiracion = $card->getExpiracion()->format('m-Y');
            list($dia, $anio) = explode("-", $expiracion);
            //var_dump($dia);
            //var_dump($anio);
        }
        else{
            $numero = 0;
            $cvc = 0;
            $expiracion = 0;
            $dia = 0;
            $anio = 0;
        }
        
        $response->setData(array(
                            'numero' => $numero,
                            'cvc' => $cvc,
                            'expiracion' => $expiracion,
                            'dia' => $dia,
                            'anio' => $anio,
                    ));    
        return $response; 
                 
        //var_dump($cita);
        
        //var_dump($cita['regs'][0]["primerNombre"]);
        //var_dump($cita);
        
        //return new Response(json_encode($cita));
    }
    
            

        
    
    
    
    /**
     * Lists all Orden entities.
     *
     * @Route("/admin/orders/filter", name="admin_view_orders_filter", options={"expose"=true})
     * @Method("GET")
     */
    public function viewOrdersFilterAction(Request $request)
    {
        $filter = $request->get('estado');
        //var_dump($filter);
        $em = $this->getDoctrine()->getManager();

//        $user = $this->get('security.token_storage')->getToken()->getUser();
        
        $dql = "SELECT o FROM DGImpresionBundle:Orden o "
                . "WHERE o.estado = :estado ORDER BY o.fechaPago ASC";
        
        $cart = $em->createQuery($dql)
                ->setParameters(array('estado'=>$filter))
                ->getResult();
        
        if(count($cart)==0){
            $estado="No orders";
        }
        else{
            $estado = $cart[0]->getEstado();
        }
        
//        $products = $em->getRepository('DGImpresionBundle:DetalleOrden')->findAll();
//        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render('orden/view_order_filter.html.twig', array(
            'orders' => $cart,
            'estado' => $estado,
        ));

    }
        

    
    
    
    /**
     * Lists all Orden entities.
     *
     * @Route("/admin/orders/cambiar/estado", name="admin_view_orders_estado_cambiar")
     * @Method("POST")
     */
    public function estadoOrdersCambiarAction(Request $request)
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
            $response = new JsonResponse();
            $orderId = $request->get('id');
            $idEstado = $request->get('idEstado');
            
            //$logo=$this->getParameter('photo.logo')."logo.png";
            $logo = $this->getRequest()->server->get('DOCUMENT_ROOT').'/siprint/web/Resources/images/logo.png';
//            var_dump($logo);
//            echo $logo;
//            die();
            $em = $this->getDoctrine()->getManager();
            
            $orden = $em->getRepository('DGImpresionBundle:Orden')->find($orderId);
            
            switch($orden->getEstado()){
                case 'pa': // orden pagada
                        if($idEstado=='pr'){
                            $orden->setEstado('pr'); //en proceso
                            $this->get('envio_correo')->sendEmail($orden->getUsuario()->getEmail(),"","","",
                                    "
                                        <table style=\"width: 540px; margin: 0 auto;\">
                                          <tr>
                                            <td class=\"panel\" style=\"border-radius:4px;border:1px #dceaf5 solid; color:#000 ; font-size:11pt;font-family:proxima_nova,'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'; padding: 30px !important; background-color: #FFF;\">
                                            <center>
                                              <img style=\"width:50%;\" src=\"http://expressionsprint.com/img/logo.jpg\">
                                            </center>
                                                <p>Su orden 
                                                <b>#".$orden->getId()."</b> esta en proceso de impresión
                                                </p>
                                            </td>
                                            <td class=\"expander\"></td>
                                          </tr>
                                        </table>
                                    ");
                        }
                        else{
                            $orden->setEstado('cn'); //cancelada
                            $this->get('envio_correo')->sendEmail($orden->getUsuario()->getEmail(),"","","","
                                        <table style=\"width: 540px; margin: 0 auto;\">
                                          <tr>
                                            <td class=\"panel\" style=\"border-radius:4px;border:1px #dceaf5 solid; color:#000 ; font-size:11pt;font-family:proxima_nova,'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'; padding: 30px !important; background-color: #FFF;\">
                                            <center>
                                              <img style=\"width:50%;\" src=\"http://expressionsprint.com/img/logo.jpg\">
                                            </center>
                                                <p>Su orden 
                                                <b>#".$orden->getId()."</b> ha sido cancelada
                                                </p>
                                            </td>
                                            <td class=\"expander\"></td>
                                          </tr>
                                        </table>
                                    ");
                        }
                    break;
                case 'cn': //cancelada
                        //$orden->setEstado('cn');
                    break;
                case 'pr': //en proceso
                        $orden->setEstado('sp'); //enviada shipped
                        $this->get('envio_correo')->sendEmail($orden->getUsuario()->getEmail(),"","","","
                                        <table style=\"width: 540px; margin: 0 auto;\">
                                          <tr>
                                            <td class=\"panel\" style=\"border-radius:4px;border:1px #dceaf5 solid; color:#000 ; font-size:11pt;font-family:proxima_nova,'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'; padding: 30px !important; background-color: #FFF;\">
                                            <center>
                                              <img style=\"width:50%;\" src=\"http://expressionsprint.com/img/logo.jpg\">
                                            </center>
                                                <p>Su orden 
                                                <b>#".$orden->getId()."</b> ha sido enviada
                                                </p>
                                            </td>
                                            <td class=\"expander\"></td>
                                          </tr>
                                        </table>");
                    break;
                case 'sp': //enviada shipped
                        //$orden->setEstado('cn'); 
                    break;
            }
            //var_dump($orden);
            //die();
    //        $user = $this->get('security.token_storage')->getToken()->getUser();
            
            
            $em->persist($orden);
            $em->flush();
            $response->setData(array(
                'flag' => 0,
            ));    
        }
        else{
            $response->setData(array(
                'flag' => -1,
            ));    
        }
        
        return $response; 
    }            
}

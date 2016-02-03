<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Orden;
use DG\ImpresionBundle\Form\OrdenType;
use Doctrine\ORM\Query\ResultSetMapping;

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

        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $ordens = $em->getRepository('DGImpresionBundle:Orden')->findBy(array('usuario'=>$user));
        
        $dql = "SELECT o FROM DGImpresionBundle:Orden o "
                . "WHERE o.usuario=:usuario AND o.estado <> 'ca' ORDER BY o.id DESC";
        
        $cart = $em->createQuery($dql)
                ->setParameters(array('usuario'=>$user->getId()))
                ->getResult();
        
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
        $em = $this->getDoctrine()->getManager();
        
        $orden = new Orden();
        $form = $this->createForm('DG\ImpresionBundle\Form\OrdenType', $orden);
        $form->handleRequest($request);
        $promotion = $this->get('promotion_img')->searchPromotion();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($orden);
            $em->flush();

            return $this->redirectToRoute('orden_show', array('id' => $orden->getId()));
        }

        //$categorias = $em->getRepository('DGImpresionBundle:Categoria')->findAll();
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NOT NULL ";
        
        $categorias = $em->createQuery($dql)
                   ->getResult();
        
        return $this->render('orden/new.html.twig', array(
            'orden' => $orden,
            'categorias' => $categorias,
            'form' => $form->createView(),
            'promotion' => $promotion,
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
        //var_dump($cart);
        $noOrden=false;
        if($cart==null){
            $noOrden=true;
        }
        $products = $em->getRepository('DGImpresionBundle:DetalleOrden')->findBy(array('orden'   => $cart
                                                                              ));
        
                                                                            
        //var_dump($cart);
        return $this->render('orden/show.html.twig', array(
            'ord' => $cart,
            'noOrden'=>$noOrden,
            'products' => $products,
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
        
        $usuario = $this->get('security.token_storage')->getToken()->getUser();
        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render('orden/store_sale.html.twig', array(
            'orden' => $orden,
            'form' => $form->createView(),
            'usuario' => $usuario,
            'promotion' => $promotion,
            
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
        
        return $this->render('orden/show_order.html.twig', array(
            'promotion' => $promotion,
            'ord' => $orden,
            'products' => $products,
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

                                                                              
        $parameters = $request->request->all();

        if($cart == NULL) {
            $orden->setUsuario($usuario);
            
            if($direccionEnvio != NULL) {
                $orden->setDireccionEnvio($direccionEnvio);
            } else {
                $orden->setDireccionEnvio(NULL);
            }
            
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
        
        $detalleorden = new \DG\ImpresionBundle\Entity\DetalleOrden();
        
        $product = $em->getRepository('DGImpresionBundle:Categoria')->find($parameters['order-now']);
        $detalleorden->setArchivo($archivo_subir);
        move_uploaded_file($_FILES['file-design']['tmp_name'], $path.$archivo_subir);

        $detalleorden->setEstado('ad');
        $detalleorden->setCategoria($product);
        $detalleorden->setOrden($orden);
        
        $em->persist($detalleorden);
        $em->flush();
        $total = 0;
        
        foreach($parameters as $key => $p){
            $atributo = new \DG\ImpresionBundle\Entity\AtributoProductoOrden();
            
            $val = explode("-", $key);
            if($val[0] == 'attributes') {
                $detalleParametro = $em->getRepository('DGImpresionBundle:DetalleParametro')->find($p);
                $atributo->setDetalleParametro($detalleParametro);
                $atributo->setDetalleOrden($detalleorden);
                $em->persist($atributo);
                $em->flush();
                
                $total+=$atributo->getDetalleParametro()->getValor();
            }    
        }
        
        $detalleorden->setMonto($total);
        $em->merge($detalleorden);
        $em->flush();
        
        $types = $em->getRepository('DGImpresionBundle:Categoria')->findBy(array('categoria' => NULL));
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NOT NULL ";
        
        $categorias = $em->createQuery($dql)
                   ->getResult();
        
        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render('categoria/productslist.html.twig', array(
            'promotion' => $promotion,
            'types' => $types,
            'categorias' => $categorias,
            'registro'=>null
        ));
    }
    
    /**
    * Ajax utilizado para buscar informacion del producto
    *  
    * @Route("/admin/show-cart", name="show-cart")
    */
    public function showCartAction()
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
            //$id = $this->get('request')->request->get('id');
             $usuario = $this->get('security.token_storage')->getToken()->getUser();
            $em = $this->getDoctrine()->getManager();            
            //$cat = $em->getRepository('DGImpresionBundle:Categoria')->find($id);
            
            $rsm = new ResultSetMapping();
            $sql = "select ca.nombre as product, "
                    . "ca.imagen as image, "
                    . "do.monto as monto "
                    . "from orden ord "
                    . "inner join detalle_orden do on ord.id = do.orden "
                    . "inner join categoria ca on do.categoria = ca.id "
                    . "where ord.usuario = ? "
                    . "and ord.estado = 'ca' ";
            
            $rsm->addScalarResult('product','product');
            $rsm->addScalarResult('image','image');
            $rsm->addScalarResult('monto','monto');
            
            $query = $em->createNativeQuery($sql, $rsm);
            $query->setParameter(1, $usuario->getId());
            $param = $query->getResult();
            
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
        //var_dump($user->getId());
        $em = $this->getDoctrine()->getManager();
        $registro = $em->getRepository('DGImpresionBundle:Orden')->find($orden);
        
        $direcciones = $em->getRepository('DGImpresionBundle:Direccion')->findBy(array('usuario'=>$user->getId()),array('defaultDir' => 'DESC'));
        $tarjetas = $em->getRepository('DGImpresionBundle:Tarjeta')->findBy(array('usuario'=>$user->getId()));
        //var_dump($tarjetas);
        
        
        
        $totalOrden = 0;
        foreach ($registro->getDetalleOrden() as $row){
            $totalOrden=$totalOrden+$row->getMonto();
        }
        //var_dump($totalOrden);
        //var_dump($direcciones);

        return $this->render('orden/checkout.html.twig', array(
            'ord' => $registro,
            'ordenId'=>$orden,
            'tarjetas'=>$tarjetas,
            'direcciones' => $direcciones,
            'totalOrden' => $totalOrden,
        ));
    }
    
    
    
    
    
    /**
     * Displays a form to edit an existing Orden entity.
     *
     * @Route("/admin/orders/delete/deletedetalle", name="orden_delete")
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
            $em->flush();
            
            $detalleOrdenRecalc = $em->gestRepository('DGImpresionBundle:DetalleOrden')->findBy(array('orden'=>$ordenId));
            
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
        if(count($address)!=0 && count($card)!=0){
            
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
            //var_dump($logo);
            //die();
            $em = $this->getDoctrine()->getManager();
            
            $orden = $em->getRepository('DGImpresionBundle:Orden')->find($orderId);
            
            switch($orden->getEstado()){
                case 'pa': // orden pagada
                        if($idEstado=='pr'){
                            $orden->setEstado('pr'); //en proceso
                            $this->get('envio_correo')->sendEmail($orden->getUsuario()->getEmail(),"","","",
                                    "<html><meta charset=\"utf-8\"><body style=\"width:100% !important;
                                            min-width: 100%;
                                            -webkit-text-size-adjust:100%; 
                                            -ms-text-size-adjust:100%; 
                                            margin:0; 
                                            padding:0;
                                            height: 100%;
                                            width: 100%;\">
                                        <table class=\"twelve columns\" style=\"width: 540px; margin: 0 auto;\">
                                          <tr>
                                            <td class=\"panel\" style=\"border-radius:4px;border:1px #dceaf5 solid; color:#000 ; font-size:11pt;font-family:proxima_nova,'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'; padding: 30px !important; background-color: #FFF;\">
                                            <center>
                                              <img src=\"$logo\" style=\"padding: 15px 25px; width: 200px;\"/>
                                            </center>
                                                <p>Su orden 
                                                <b>#".$orden->getId()."</b> esta en proceso de impresión
                                                </p>
                                            </td>
                                            <td class=\"expander\"></td>
                                          </tr>
                                        </table>
                                    </body>
                                    </html>");
                        }
                        else{
                            $orden->setEstado('cn'); //cancelada
                            $this->get('envio_correo')->sendEmail($orden->getUsuario()->getEmail(),"","","","<html><meta charset=\"utf-8\"><body style=\"width:100% !important;
                                            min-width: 100%;
                                            -webkit-text-size-adjust:100%; 
                                            -ms-text-size-adjust:100%; 
                                            margin:0; 
                                            padding:0;
                                            height: 100%;
                                            width: 100%;\">
                                        <table class=\"twelve columns\" style=\"width: 540px; margin: 0 auto;\">
                                          <tr>
                                            <td class=\"panel\" style=\"border-radius:4px;border:1px #dceaf5 solid; color:#000 ; font-size:11pt;font-family:proxima_nova,'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'; padding: 30px !important; background-color: #FFF;\">
                                            <center>
                                              <img src=\"".$logo."\" style=\"padding: 15px 25px; width: 200px;\">
                                            </center>
                                                <p>Su orden 
                                                <b>#".$orden->getId()."</b> ha sido cancelada
                                                </p>
                                            </td>
                                            <td class=\"expander\"></td>
                                          </tr>
                                        </table>
                                    </body>
                                    </html>");
                        }
                    break;
                case 'cn': //cancelada
                        //$orden->setEstado('cn');
                    break;
                case 'pr': //en proceso
                        $orden->setEstado('sp'); //enviada shipped
                        $this->get('envio_correo')->sendEmail($orden->getUsuario()->getEmail(),"","","","<html><meta charset=\"utf-8\"><body style=\"width:100% !important;
                                            min-width: 100%;
                                            -webkit-text-size-adjust:100%; 
                                            -ms-text-size-adjust:100%; 
                                            margin:0; 
                                            padding:0;
                                            height: 100%;
                                            width: 100%;\">
                                        <table class=\"twelve columns\" style=\"width: 540px; margin: 0 auto;\">
                                          <tr>
                                            <td class=\"panel\" style=\"border-radius:4px;border:1px #dceaf5 solid; color:#000 ; font-size:11pt;font-family:proxima_nova,'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'; padding: 30px !important; background-color: #FFF;\">
                                            <center>
                                              <img src=\"".$logo."\" style=\"padding: 15px 25px; width: 200px;\">
                                            </center>
                                                <p>Su orden 
                                                <b>#".$orden->getId()."</b> ha sido enviada
                                                </p>
                                            </td>
                                            <td class=\"expander\"></td>
                                          </tr>
                                        </table>
                                    </body>
                                    </html>");
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
//        $products = $em->getRepository('DGImpresionBundle:DetalleOrden')->findAll();
//        $promotion = $this->get('promotion_img')->searchPromotion();

        return $response; 

    }
        
    
}

<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * General controller.
 *
 * @Route("/")
 */

class GeneralController extends Controller
{
    /**
     * Muestra la pagina de Index
     *
     * @Route("/index", name="dg_general_index")
     * 
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NOT NULL "
                . "AND p.estado = 1 "
                . "AND p.categoria <> 38 "
                . "ORDER BY p.id DESC ";
        
        $products = $em->createQuery($dql)
                         ->getResult();
        
        $tot_products = count($products);
        $idproducts=array();
        foreach ($products as $key => $value) {
            array_push ($idproducts, $value->getId());
        }
        
        if($tot_products > 4) {
            $cantidad = 4;
        } else {
            $cantidad = $tot_products;
        }
        
        $prom_random=array();
        $idRecuperados=array();
        
        
        while( count($prom_random) < $cantidad ){
            
            $random = array_rand($idproducts, 1);
            $prom= $em->getRepository('DGImpresionBundle:Categoria')->find($idproducts[$random]);

            if(!in_array($random, $idRecuperados, true)){
                if(count($prom)!=0){
                    array_push ($prom_random, $prom);
                    array_push ($idRecuperados, $random);
                }
            }
        }
        
        return $this->render('General/index.html.twig', array(
            'prom_random' => $prom_random,
            'idRecuperados' => $idRecuperados
        ));
    }
    
    /**
     * Muestra la pagina de About us
     *
     * @Route("/about-us", name="dg_general_about")
     * 
     */
    public function aboutUsAction()
    {
        return $this->render(':General:about.html.twig');
    }
    
    /**
     * Muestra la pagina de Contact us
     *
     * @Route("/contacto-us", name="dg_general_contacto")
     * 
     */
    public function contactUsAction()
    {
        return $this->render(':General:contact.html.twig');
    }
    
    /**
     * Muestra la pagina de How to order
     *
     * @Route("/how-to-order", name="dg_general_how_order")
     * 
     */
    public function howToOrderAction()
    {
        return $this->render(':General:howToOrder.html.twig');
    }
    
    /**
     * Muestra la pagina de T-Shirt Printing
     *
     * @Route("/t-shirt-printing", name="dg_general_tshirt_printing")
     * 
     */
    public function tShirtPrintingAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria = :tshirt "
                . "AND p.estado = 1 ";
        
        $categorias = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();
        
        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render(':General:tshirtPrinting.html.twig', array(
            'categorias' => $categorias,
            'promotion' => $promotion,
            'registro'=>null,
            'camisas'=>0,
        ));
    }
}

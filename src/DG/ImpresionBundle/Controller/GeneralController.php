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
        return $this->render(':General:index.html.twig');
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
     * @Route("/contact-us", name="dg_general_contact")
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
        return $this->render(':General:tshirtPrinting.html.twig');
    }
}

<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DG\ImpresionBundle\Entity\Orden;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Reporte controller.
 *
 * @Route("/admin/report")
 */
class ReportController extends Controller
{
    /**
     * @Route("/{id}/invoice/{tipo}", name="admin_reporte_invoice", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function pdfAction(Orden $orden, $tipo)
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('DGImpresionBundle:DetalleOrden')->findBy(array('orden'   => $orden
                                                                              ));
                                                                             // var_dump($products);       
        $pdf = $this->get('fpdf_printer')->toPDF($products, $tipo);
        
        //var_dump($pdf);
    }
}

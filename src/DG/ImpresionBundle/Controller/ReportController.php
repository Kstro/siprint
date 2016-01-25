<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DGPlusbelleBundle\Entity\Persona;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Reporte controller.
 *
 * @Route("/admin/reporte")
 */
class ReportController extends Controller
{
    /**
     * @Route("/informe", name="report"), options ={"expose" = true})
     * @Method("GET")
     * @Template()
     */
    public function pdfAction()
    {
        $this->get('fpdf_printer')->toPDF();
    }
}

<?php

namespace DG\ImpresionBundle\Service;

use DG\ImpresionBundle\Report\ReportePDF;

class FPDFService {
    
    private $pdf;
 
    public function __construct(ReportePDF $pdf)
    {
        $this->pdf = $pdf;
    }
    
    public function toPDF()
    {
         $this->pdf->FPDF('L','mm','Letter');
	$this->pdf->SetTopMargin(20);
	$this->pdf->SetLeftMargin(20);
        
        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255);
        
        $this->pdf->SetFont('Times','B',16);
        $this->pdf->Cell(180,32,'$saludo', 0, 0, 'C');
        
        $this->pdf->Output();
        //return $this->pdf;
    }
    
}

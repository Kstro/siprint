<?php

namespace DG\ImpresionBundle\Service;

use DG\ImpresionBundle\Report\ReportePDF;

class FPDFService {
    
    private $pdf;
 
    public function __construct(ReportePDF $pdf)
    {
        $this->pdf = $pdf;
    }
    
    public function toPDF($orden)
    {
        $this->pdf->FPDF('P','mm','Letter');
	$this->pdf->SetTopMargin(20);
	$this->pdf->SetLeftMargin(20);
        
        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255);
        
        $break = 0;
        
        $this->pdf->Ln(16);
        $break+=16;
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(0, 10, 'Order Placed:',0,0);

        $this->pdf->SetX(43);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->Cell(0, 10, $orden[0]->getOrden()->getFechaOrden()->format("F d, Y"), 0, 0);
        
        $this->pdf->Ln(5);
        $break+=5;
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(0, 10, 'Order Number:',0,0);
        
        $this->pdf->SetX(46);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->Cell(0, 10, $orden[0]->getOrden()->getId(), 0, 0);
        
        $total = 0;
        foreach ($orden as $key => $value) {
            $total+=$value->getMonto();
        }
        
        $this->pdf->Ln(5);
        $break+=5;
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(0, 10, 'Order Total: $',0,0);
        
        $this->pdf->SetX(44);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->Cell(0, 10, number_format($total, 2), 0, 0);
        
        $this->pdf->Ln(15);
        $break+=15;
        $customer_top = $break + 20;
        $this->pdf->SetFont('Arial','B',11);
        $this->pdf->Cell(0, 10, 'Customer Information', 0, 0, 'C');
        
        $this->pdf->Ln(12);
        $break+=12;
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(0, 10, 'Customer name:',0,0);
        
        $this->pdf->SetX(50);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->Cell(0, 10, $orden[0]->getOrden()->getUsuario()->getPersona(), 0, 0);
        
        $this->pdf->Ln(6);
        $break+=6;
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(0, 10, 'Shipping Address:',0,0);
        
        $this->pdf->SetX(50);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->Cell(0, 10, $orden[0]->getOrden()->getDireccionEnvio()->getLinea1(), 0, 0);
        
        $this->pdf->Ln(5);
        $break+=5;
        $this->pdf->SetX(50);
        $this->pdf->Cell(0, 10, $orden[0]->getOrden()->getDireccionEnvio()->getCity() . ', ' . $orden[0]->getOrden()->getDireccionEnvio()->getState(), 0, 0);
        
        $this->pdf->Ln(5);
        $break+=5;
        $this->pdf->SetX(50);
        $this->pdf->Cell(0, 10, $orden[0]->getOrden()->getDireccionEnvio()->getZipCode(), 0, 0);
        
        $this->pdf->SetLineWidth(0.35);
        $this->pdf->Line(20, $customer_top, 20, $break + 30);
        $this->pdf->Line(207, $customer_top, 207, $break + 30);
        $this->pdf->Line(20, $customer_top, 207, $customer_top);
        $this->pdf->Line(20, $customer_top + 10, 207, $customer_top + 10);
        $this->pdf->Line(20, $break + 30, 207, $break + 30);
        
        $this->pdf->Ln(15);
        $break+=15;
        $this->pdf->SetFont('Arial','B',11);
        $this->pdf->Cell(0, 10, 'Detail Order', 0, 0, 'C');
        
        $top_border = $break + 20;
        
        $this->pdf->Ln(12);
        $break+=12;
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->setX(25);
        $this->pdf->Cell(0, 10, 'Quantity', 0, 0);
        $this->pdf->setX(50);
        $this->pdf->Cell(0, 10, 'Items Ordered', 0, 0);
        $this->pdf->Cell(0, 10, 'Price', 0, 0, 'R');
            
        $this->pdf->Ln(6);
        $break+=6;
        $this->pdf->SetFont('Arial', '', 9);
        
        foreach ($orden as $key => $value) {
            $this->pdf->setX(28);
            
            foreach ($value->getAtributoProductoOrden() as $clave => $valor) {
                if($valor->getDetalleParametro()->getParametro() == 'Quantity') {
                    $this->pdf->Cell(0, 10, $valor->getDetalleParametro(), 0, 0);
                }    
            }
            
            $this->pdf->setX(50);
            $this->pdf->Cell(0, 10, $value->getCategoria(), 0, 0);
            $this->pdf->Cell(0, 10, '$ ' . number_format($value->getMonto(), 2), 0, 0, 'R');
            $this->pdf->Ln(5);
            $break+=5;
        }
        
        $this->pdf->Ln(5);
        $break+=4;
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->setX(173);
        $this->pdf->Cell(0, 10, 'Total', 0, 0);
        $this->pdf->Cell(0, 10, '$ ' . number_format($total, 2), 0, 0, 'R');
        $this->pdf->SetLineWidth(0.2);
        $this->pdf->Line(20, $break + 19, 207, $break+ 19 );
//        $this->pdf->Line(170, $break + 19, 170, $break+ 32 );
        
        $this->pdf->SetLineWidth(0.35);
        
        $this->pdf->Line(20, $top_border, 20, $break + 32);
        $this->pdf->Line(207, $top_border, 207, $break + 32);
        $this->pdf->Line(20, $top_border, 207, $top_border);
        $this->pdf->Line(20, $top_border + 10, 207, $top_border + 10);
        $this->pdf->Line(20, $break + 32, 207, $break + 32);
        $this->pdf->Output();
        
        return $this->pdf;
    }
    
}
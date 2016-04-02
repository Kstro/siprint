<?php

namespace DG\ImpresionBundle\Service;

use DG\ImpresionBundle\Report\ReportePDF;

class FPDFService {
    
    private $pdf;
 
    public function __construct(ReportePDF $pdf)
    {
        $this->pdf = $pdf;
    }
    
    public function toPDF($orden, $tipo, $tax)
    {
        $this->pdf->FPDF('P','mm','Letter');
	$this->pdf->SetTopMargin(20);
	$this->pdf->SetLeftMargin(20);
        $this->pdf->SetRightMargin(20);
        
        $this->pdf->AddPage();
        $this->pdf->SetFillColor(255);
        $this->pdf->SetTitle('Final Details for Order');
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
        
        if($tipo == 1){
            $this->pdf->Cell(0, 10, '#IN'.$orden[0]->getOrden()->getId(), 0, 0);
        } else {
            $this->pdf->Cell(0, 10, '#ON'.$orden[0]->getOrden()->getId(), 0, 0);
        }    
        
        $total = 0;
        $tax_total = 0;
        $tax_prod = 0;
        foreach ($orden as $key => $value) {
            $total+=$value->getMonto();
            $tax_prod+=$value->getTax() * $value->getMonto();
            $tax_total+=$value->getMonto() + ($value->getTax() * $value->getMonto());
        }
        
        $this->pdf->Ln(5);
        $break+=5;
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(0, 10, 'Order Total:',0,0);
        
        $this->pdf->SetX(44);
        $this->pdf->SetFont('Arial','',9);
        $this->pdf->Cell(0, 10, '$ ' . number_format($tax_total, 2), 0, 0);
        
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
        
        if( $orden[0]->getOrden()->getUsuario() != NULL ){
            $this->pdf->Cell(0, 10, $orden[0]->getOrden()->getUsuario()->getPersona(), 0, 0);
        } else {
            $this->pdf->Cell(0, 10, $orden[0]->getOrden()->getCliente(), 0, 0);
        }
        
        $this->pdf->Ln(6);
        $break+=6;
        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(0, 10, 'Company:',0,0);
        $this->pdf->SetX(50);
        $this->pdf->SetFont('Arial','',9);
        
        if($orden[0]->getOrden()->getCliente()->getOtro() != NULL){
            $this->pdf->Cell(0, 10, $orden[0]->getOrden()->getCliente()->getOtro(), 0, 0);
        } else {
            $this->pdf->Cell(0, 10, 'Unregistered',0,0);
        }
        
        $this->pdf->Ln(6);
        $break+=6;
        
        
        
        if($orden[0]->getOrden()->getDireccionEnvio()) 
        {    
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
        }    
//        else {
//            $this->pdf->SetX(50);
//            $this->pdf->SetFont('Arial','',9);
//            $this->pdf->Cell(0, 10, $orden[0]->getOrden()->getDireccionEnvioGuardar(), 0, 0);
//        }
        
            
        $this->pdf->SetLineWidth(0.35);
        $this->pdf->Line(20, $customer_top, 20, $break + 30);
        $this->pdf->Line(197, $customer_top, 197, $break + 30);
        $this->pdf->Line(20, $customer_top, 197, $customer_top);
        $this->pdf->Line(20, $customer_top + 10, 197, $customer_top + 10);
        $this->pdf->Line(20, $break + 30, 197, $break + 30);
        
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
        $this->pdf->setX(145);
        $this->pdf->Cell(0, 10, 'Price', 0, 0);
        $this->pdf->setX(162);
        $this->pdf->Cell(0, 10, 'Tax'.' ('. $tax->getValor() * 100 .'%)', 0, 0);
        $this->pdf->Cell(0, 10, 'Total', 0, 0, 'R');
            
        $this->pdf->Ln(6);
        $break+=6;
        $this->pdf->SetFont('Arial', '', 9);
        
        foreach ($orden as $key => $value) {
            $this->pdf->setX(28);
            
            foreach ($value->getAtributoProductoOrden() as $clave => $valor) {
                if($valor->getOpcionProducto()->getDetalleParametro()->getParametro() == 'Quantity' || $valor->getOpcionProducto()->getDetalleParametro()->getParametro() == 'Quantity T-Shirt') {
                    $this->pdf->Cell(0, 10, $valor->getOpcionProducto()->getDetalleParametro(), 0, 0);
                }    
            }
            
            $this->pdf->setX(50);
            $this->pdf->Cell(0, 10, $value->getCategoria(), 0, 0);
            $this->pdf->setX(144);
            $this->pdf->Cell(0, 10, '$ ' . number_format($value->getMonto(), 2), 0, 0);
            $this->pdf->setX(164);
            $this->pdf->Cell(0, 10, '$ ' . number_format($value->getTax() * $value->getMonto(), 2), 0, 0);
            $this->pdf->Cell(0, 10, '$ ' . number_format($value->getMonto() + ($value->getTax() * $value->getMonto()), 2), 0, 0, 'R');
            $this->pdf->Ln(5);
            $break+=5;
        }
        
        $this->pdf->Ln(5);
        $break+=4;
        $this->pdf->SetFont('Arial', 'B', 10);
        $this->pdf->setX(110);
        $this->pdf->Cell(0, 10, 'Sub - total', 0, 0);
        $this->pdf->setX(144);
        $this->pdf->Cell(0, 10, '$ ' . number_format($total, 2), 0, 0);
        $this->pdf->setX(164);
        $this->pdf->Cell(0, 10, '$ ' . number_format($tax_prod, 2), 0, 0);
        $this->pdf->Cell(0, 10, '$ ' . number_format($tax_total, 2), 0, 0, 'R');
        $this->pdf->SetLineWidth(0.2);
        $this->pdf->Line(20, $break + 19, 197, $break+ 19 );
//        $this->pdf->Line(170, $break + 19, 170, $break+ 32 );
        
        
        $monto_cancelar = 0;
        $promocion = 0;
        if( $orden[0]->getOrden()->getPorcentaje() != NULL ){
            $monto_cancelar = $total - (( $orden[0]->getOrden()->getPorcentaje() * $tax_total ) / 100);
            $promocion = ( $orden[0]->getOrden()->getPorcentaje() * $tax_total ) / 100;
        } else {
            $monto_cancelar = $tax_total;
        }
        
        $this->pdf->Ln(10);
        $break+=10;
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->setX(110);
        $this->pdf->Cell(0, 10, 'Promotion applied', 0, 0);
        $this->pdf->Cell(0, 10, '($ ' . number_format($promocion, 2). ')', 0, 0, 'R');
        
//        $this->pdf->Ln(5);
//        $break+=5;
//        $this->pdf->SetFont('Arial', '', 10);
//        $this->pdf->setX(152);
//        $this->pdf->Cell(0, 10, 'Tax applied', 0, 0);
//        $this->pdf->Cell(0, 10, '$ ' .number_format($monto_cancelar * 0.09, 2), 0, 0, 'R');
        
        $this->pdf->Ln(12);
        $break+=12;
        $this->pdf->SetFont('Arial', 'B', 13);
        $this->pdf->setX(110);
        $this->pdf->Cell(0, 10, 'Total amount', 0, 0);
        $this->pdf->Cell(0, 10, '$ ' . number_format($monto_cancelar, 2), 0, 0, 'R');
        
        $this->pdf->Line(20, $break + 20, 197, $break + 20);
        
        $this->pdf->SetLineWidth(0.35);
        //$this->pdf->SetDrawColor(255,255,255);
        $this->pdf->Line(20, $top_border, 20, $break + 32);
        $this->pdf->Line(197, $top_border, 197, $break + 32);
        $this->pdf->Line(20, $top_border, 197, $top_border);
        $this->pdf->Line(20, $top_border + 10, 197, $top_border + 10);
        $this->pdf->Line(20, $break + 32, 197, $break + 32);
        
        $this->pdf->Output();
        
        return $this->pdf;
    }
    
}

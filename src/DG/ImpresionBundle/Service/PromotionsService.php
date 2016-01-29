<?php

namespace DG\ImpresionBundle\Service;

use DG\ImpresionBundle\Entity\Promocion;
use Doctrine\ORM\EntityManager;
/**
 *   PromotionsService
 */
class PromotionsService {
    protected $em;
    
    public function __construct(EntityManager $em){
        $this->em=$em;
    }
    
    public function searchPromotion(){
        $promoImg = new Promocion();
        
        $promotions = $this->em->getRepository('DGImpresionBundle:Promocion')->findBy(array(),array('id'=>'DESC'));
        $idMax = $promotions[0]->getId();
       
        $random = rand(1,$idMax);
        $prom= $this->em->getRepository('DGImpresionBundle:Promocion')->find($random);
        
        return array(
            'promotion'=>$prom,
        );  
    }       
}

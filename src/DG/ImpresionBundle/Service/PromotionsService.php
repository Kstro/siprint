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
        //$promoImg = new Promocion();
        
        $promotions = $this->em->getRepository('DGImpresionBundle:Promocion')->findBy(array(),array('id'=>'DESC'));
        //var_dump($promotions);
        
        if(!empty($promotions )){
            $idMax = $promotions[0]->getId();
        
            $random = rand(1,$idMax);
            $prom= $this->em->getRepository('DGImpresionBundle:Promocion')->find($random);
        } else {
            $prom = NULL;
        }
            
        return array(
            'promotion'=>$prom,
        );  
    }     
    
    public function randomPromotion(){
        //$promoImg = new Promocion();
        
        $promotions = $this->em->getRepository('DGImpresionBundle:Promocion')->findBy(array(),array('id'=>'DESC'));
        $idMax = $promotions[0]->getId();
        $prom_random=array();
        $idRecuperados=array();
        
        while(count($prom_random)<8){
            
            $random = rand(1,$idMax);
            $prom= $this->em->getRepository('DGImpresionBundle:Promocion')->find($random);
            
            if(!in_array($random, $idRecuperados, true)){
                if(count($prom)!=0){
                    array_push ($prom_random, $prom);
                    array_push ($idRecuperados, $random);
                }
            }
        }
        
            
        return array(
            'promo_rnd'=>$prom_random,
            'i_dpromo'=>$idRecuperados,
        );  
    } 
}

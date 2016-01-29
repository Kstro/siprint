<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/admin")
 */
class UserAccountController extends Controller{
    /**
     * @Route("/myaccount", name="dg_my_account")
     * 
     */
    public function MyAccountAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuario= $this->get('security.token_storage')->getToken()->getUser();
        
        $dql = "SELECT d FROM DGImpresionBundle:Direccion d "
                . "WHERE d.usuario=:usuario "
                . "AND d.defaultDir=:dir "
                . "ORDER BY d.defaultDir DESC, d.name";
        
        $direccions = $em->createQuery($dql)
                   ->setParameter('usuario', $usuario)
                   ->setParameter('dir', TRUE)
                   ->getResult();
           
        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render(':useraccount:myaccount.html.twig', array(
            'direccion' => $direccions,
            'promotion' => $promotion,
        ));
    }
}

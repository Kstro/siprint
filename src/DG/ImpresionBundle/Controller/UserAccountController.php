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
        
        if(isset($_COOKIE['expressionsPrint'])){
            $user_cart = $em->getRepository('DGImpresionBundle:Orden')->findOneBy(array('estado'   => 'ca',
                                                                                    'usuario'  => $usuario
                                                                                   ));
            
            $registro = $em->getRepository('DGImpresionBundle:Orden')->findOneBy(array('estado'   => 'ca',
                                                                                        'cookie'  => $_COOKIE['expressionsPrint']
                                                                                       ));
            
            if($user_cart == NULL){
                $registro->setUsuario($usuario);
                
                $cliente = $em->getRepository('DGImpresionBundle:Cliente')->findOneBy(array('persona' => $usuario->getPersona()));
                $registro->setCliente($cliente);
                
            } else {
                $products = $em->getRepository('DGImpresionBundle:DetalleOrden')->findBy(array('orden' => $registro));
                $registro->setEstado('zz');
                
                foreach ($products as $key => $product) {
                    $product->setOrden($user_cart); 
                    $em->merge($product);
                    $em->flush();
                }
            }                        
            
            $registro->setCookie(NULL);
            $em->merge($registro);
            $em->flush();
            
            //Destruccion de la cookie
            unset($_COOKIE['expressionsPrint']);
            setcookie('expressionsPrint', "", time()-3600, "/");
        }   
                
        return $this->render(':useraccount:myaccount.html.twig', array(
            'direccion' => $direccions,
            'promotion' => $promotion,
        ));
    }
}

<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use DG\ImpresionBundle\Entity\Usuario;
use DG\ImpresionBundle\Controller\UsuarioController;

/**
 * @Route("/secured")
 */
class SecuredController extends Controller
{

    /**
     * @Route("/login", name="admin_secured_login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
//        $usuario = new Usuario();
//        $user = new UsuarioController();
//        $form = $user->createForm('DG\ImpresionBundle\Form\UsuarioType', $usuario);
        //return $this->render('DGImpresionBundle:Secured:login.html.twig');
        $session = $request->getSession();
        if (class_exists('\Symfony\Component\Security\Core\Security')) {
            $authErrorKey = Security::AUTHENTICATION_ERROR;
            $lastUsernameKey = Security::LAST_USERNAME;
        } else {
            // BC for SF < 2.6
            $authErrorKey = SecurityContextInterface::AUTHENTICATION_ERROR;
            $lastUsernameKey = SecurityContextInterface::LAST_USERNAME;
        }
        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }
        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return array(
            'last_username' => $lastUsername,
            'promotion' => $promotion,
            'error' => $error,
            'mensaje'=>null,
//            'usuario' => $usuario,
//            'form' => $form,
            
        );
        
    }

    /**
     * @Route("/login_check", name="admin_security_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
        
    }

    /**
     * @Route("/logout", name="admin_secured_logout")
     */
    public function logoutAction()
    {
        
    }   
    
    /**
     * Recuperar contraseña
     * 
     * @Route("/reset-password", name="admin_reset_passw")
     */
    public function resetPasswordAction() {
        return $this->render('DGImpresionBundle:Secured:reset_password.html.twig');
    }
    
    /**
     * Recuperar contraseña
     * 
     * @Route("/forgot-password", name="admin_forgot_passw")
     */
    public function forgotPasswordAction(Request $request) 
    {
        $parameters = $request->request->all();
        $email = $parameters['email'];
        
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('DGImpresionBundle:Usuario')->findOneBy(array('email' => $email));        

        
        $password = $this->generateRandomString(12);
        $usuario->setPassword($password);
        $this->setSecurePassword($usuario);
        
        $this->get('envio_correo')->sendEmail($usuario->getEmail(), "", "", "",
                    "
                        <table style=\"width: 540px; margin: 0 auto;\">
                          <tr>
                            <td class=\"panel\" style=\"border-radius:4px;border:1px #dceaf5 solid; color:#000 ; font-size:11pt;font-family:proxima_nova,'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'; padding: 30px !important; background-color: #FFF;\">
                            <center>
                              <img style=\"width:50%;\" src=\"http://expressionsprint.com/img/logo.jpg\">
                            </center>
                                <p>" . $usuario->getPersona() . ", you have requested to reset your password, then displays your new password.</p>
                                <p> User:" . $usuario->getUsername() . "</p>
                                <p> Email: " . $email . "</p>
                                <p><b> Password: " . $password . "</b></p>
                                <p>Thanks, by the use of our services. </p>    
                            </td>
                            <td class=\"expander\"></td>
                          </tr>
                        </table>
                    ");
        //var_dump($password);
        //var_dump($usuario);
         
        
        //die();
        $em->persist($usuario);
        $em->flush();
            
        $mensaje="He sent you the new password to your email, to enter the new password that has been sent.";
        
        return $this->render('usuario/accountcreated.html.twig', array(
            'mensaje'=>$mensaje,
            'redirect'=>'Login',
            'header'=>'Your password has been changed',
        ));    
    }
    
    /**
    * Ajax utilizado para buscar el email ingresado
    *  
    * @Route("/admin/search-email", name="admin_search_email")
    */
    public function adminSearchEmailAction()
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
            $em = $this->getDoctrine()->getManager();
            $email = $this->get('request')->request->get('email');
            
            $usuario = $em->getRepository('DGImpresionBundle:Usuario')->findBy(array('email' => $email));        
            $valido = 0;
                    
            if($usuario != NULL){
                $valido = 1;
            } 
            
            $response = new JsonResponse();
            $response->setData(array(
                                'valido'  => $valido,
                                'usuario' => $usuario
                            )); 
            
            return $response; 
        } else {    
            return new Response('0');              
        }  
    }
    
    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        
        return $randomString;
    }
    
    private function setSecurePassword(&$entity) {
        $entity->setSalt(md5(time()));
        $encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
        $entity->setPassword($password);
    }
    
}
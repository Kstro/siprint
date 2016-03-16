<?php

namespace DG\ImpresionBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Usuario;
use DG\ImpresionBundle\Entity\Persona;
use DG\ImpresionBundle\Entity\Cliente;
use DG\ImpresionBundle\Form\UsuarioType;

/**
 * Usuario controller.
 *
 * @Route("/admin/usuario")
 */
class UsuarioController extends Controller
{
    /**
     * Lists all Usuario entities.
     *
     * @Route("/", name="admin_usuario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser(); 
        
        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT p, u FROM DGImpresionBundle:Usuario u "
                . "JOIN u.persona p WHERE p.estado=:pestado "
                . "AND u.estado=:uestado AND u.id <> :usuario ";
        
        $usuarios = $em->createQuery($dql)
                   ->setParameter('pestado', 1)
                   ->setParameter('uestado', 1)
                   ->setParameter('usuario', $user->getId())
                   ->getResult();

        $promotion = $this->get('promotion_img')->searchPromotion();
        //var_dump($promotion);
        return $this->render('usuario/index.html.twig', array(
            'usuarios' => $usuarios,
            'promotion' => $promotion,
        ));
    }

    /**
     * Creates a new Usuario entity.
     *
     * @Route("/new", name="admin_usuario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $usuario = new Usuario();
        $form = $this->createForm('DG\ImpresionBundle\Form\UsuarioType', $usuario);
        $form->add('user_roles','entity',array('label' => 'Select a role','required'=>false,
                'class'=>'DGImpresionBundle:Rol','property'=>'nombre',
                'multiple'=>true,
                'expanded'=>true,
                    'attr'=>array(
                    'class'=>'roles'
                    )));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //establecemos la contraseña: --------------------------
            $this->setSecurePassword($usuario);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            $persona = $usuario->getPersona()->getId();
            $entity = $em->getRepository('DGImpresionBundle:Persona')->find($persona);
            $entity->setEstado(1);
            $em->merge($entity);
            $em->flush();
            
            //return $this->redirectToRoute('admin_usuario_show', array('id' => $usuario->getId()));
            return $this->redirectToRoute('admin_usuario_index');
        }

        return $this->render('usuario/new.html.twig', array(
            'usuario' => $usuario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     * @Route("/{id}", name="admin_usuario_show")
     * @Method("GET")
     */
    public function showAction(Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);

        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render('usuario/show.html.twig', array(
            'usuario' => $usuario,
            'promotion' => $promotion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     * @Route("/{id}/edit", name="admin_usuario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\UsuarioType', $usuario);
        
        //obtiene la contraseña actual -----------------------
        $current_pass = $usuario->getPassword();
        
        $editForm->handleRequest($request);
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            //evalua si la contraseña se encuentra vacia
            if($usuario->getPassword()==""){
                $usuario->setPassword($current_pass);
            }
            //evalua si la contraseña fue modificada: ------------------------
            if ($current_pass != $usuario->getPassword()) {
                $this->setSecurePassword($usuario);
            }
            $em->persist($usuario);
            $em->flush();

            //return $this->redirectToRoute('admin_usuario_edit', array('id' => $usuario->getId()));
            return $this->redirectToRoute('admin_usuario_show', array('id' => $usuario->getId()));
        }

        return $this->render('usuario/edit.html.twig', array(
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Usuario entity.
     *
     * @Route("/{id}", name="admin_usuario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Usuario $usuario)
    {
        $form = $this->createDeleteForm($usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usuario);
            $em->flush();
        }

        return $this->redirectToRoute('admin_usuario_index');
    }

    /**
     * Creates a form to delete a Usuario entity.
     *
     * @param Usuario $usuario The Usuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usuario $usuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_usuario_delete', array('id' => $usuario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    private function setSecurePassword(&$entity) {
        $entity->setSalt(md5(time()));
        $encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
        $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
        $entity->setPassword($password);
    }
    
     /**
     * Creates a new Usuario entity.
     *
     * @Route("/creat", name="admin_usuario_creat")
     * @Method("POST")
     * @Template('DGImpresionBundle:Secured:login.html.twig')
     */
//    public function createAction(Request $request)
//    {
//        var_dump($request);
//        $entity = new Usuario();
//        $user = new UsuarioController();
//       $form = $user->createForm('DG\ImpresionBundle\Form\UsuarioType', $entity);
//        $form->handleRequest($request);
//        var_dump($request->request->all());
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $this->setSecurePassword($entity);
//            $em->persist($entity);
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('admin_usuario'));
//        }
//
//        return array(
//            'entity' => $entity,
//            'form'   => $form->createView(),
//        );
//    }
    
    /**
     * Creates a new Usuario entity.
     *
     * @Route("/registeruser/register", name="admin_usuario_register")
     * @Method({"GET", "POST"})
     */
    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = new Usuario();
        $persona = new Persona();
        $form = $this->createForm('DG\ImpresionBundle\Form\UsuarioType', $usuario);
        $form->handleRequest($request);
//        var_dump($_POST['email']);
        $usuarioBuscar="";
        
        
        
        
            if($_POST['email']!="" && $_POST['password']!="" ){
                if($_POST['re-password']!= $_POST['password'] ){
                    $mensaje = "Las contraseñas deben ser iguales";
                    
                    return $this->render('usuario/accountcreated.html.twig', array(
                        'mensaje'=>$mensaje,
                        'redirect'=>'Try again',
                        'header'=>'Error...',
                    ));
                }
                
                $usuarioBuscar = $em->getRepository('DGImpresionBundle:Usuario')->findBy(array('email'=>$_POST['email'],'username'=>$_POST['username']));
                if(count($usuarioBuscar)==0){
                    //var_dump('usuario no existe,crearlo');
                    $persona->setNombres($_POST['firstname']);
                    $persona->setApellidos($_POST['lastname']);
                    $usuario->setPassword($_POST['password']);
                    //die();
                    $persona->setTelefono(null);

                    $persona->setEstado(1);
                    $usuario->setEstado(1);
                    //evalua si la contraseña fue modificada: ------------------------
                    $this->setSecurePassword($usuario);

                    $usuario->setPersona($persona);
                    //$usuario->setPersona();
                    $usuario->setEmail($_POST['email']);
                    //$usuario->setPassword($_POST['email']);

                    $rol = $em->getRepository('DGImpresionBundle:Rol')->find(2);

                    $usuario->addRol($rol);

                    $usuario->setUsername($_POST['username']);

                    $usuario->isEnabled(1);
                    //var_dump($usuario);
                    //var_dump($_POST);

            //if ($form->isSubmitted()) {
                //establecemos la contraseña: --------------------------


                    $em->persist($persona);
                    $em->persist($usuario);
                    //$em->persist($usuario);
                    $em->flush();
                    
                    $cliente = new Cliente();
                    $cliente->setEstado(1);
                    $cliente->setPersona($persona);
                    $em->persist($cliente);
                    $em->flush();
                    
                    $mensaje="Cuenta creada con éxito";
                    //return $this->redirectToRoute('admin_usuario_show', array('id' => $usuario->getId()));
                    //return $this->redirectToRoute('admin_account_created');
                    return $this->render('usuario/accountcreated.html.twig', array(
                        'mensaje'=>$mensaje,
                        'redirect'=>'Login',
                        'header'=>'Account created',
                    ));
                }
                else{
                    $mensaje="El correo o el nombre de usuario proporcionado ya existe";
                    return $this->render('usuario/accountcreated.html.twig', array(
                        'mensaje'=>$mensaje,
                        'redirect'=>'Login',
                        'header'=>'Error...',
                    ));
                    //var_dump('usuario existe, no se creo usuario');
                }
            }
            else{
                $mensaje = "Debe ingresar un correo";
                if($_POST['password']=="" ){
                    $mensaje = "Debe una contraseña";
                }
                return $this->render('usuario/accountcreated.html.twig', array(
                    'mensaje'=>$mensaje,
                    'redirect'=>'Try again',
                    'header'=>'Error...',
                ));
            }
        
        //var_dump($usuarioBuscar);
        //die();
        
        //}
        //$mensaje=null;

//        return $this->render('DGImpresionBundle:Secured:login.html.twig', array(
//            'usuario' => $usuario,
//            'mensaje' => $mensaje,
//            'form' => $form->createView(),
//        ));
    }
    
    
    /**
     * Creates a new Usuario entity.
     *
     * @Route("/account/created", name="admin_account_created")
     * @Method({"GET"})
     */
    public function accountcreatedAction(Request $request)
    {
        //die();
        
        //if ($form->isSubmitted()) {
            //establecemos la contraseña: --------------------------                
            
            
        $mensaje="Cuenta creada con éxito";
            //return $this->redirectToRoute('admin_usuario_show', array('id' => $usuario->getId()));
        //return $this->redirectToRoute('admin_secured_login');
        //}
        //$mensaje=null;
        return $this->render('usuario/accountcreated.html.twig', array(
            'mensaje'=>$mensaje,
        ));
//        return array(
//            'mensaje'=>$mensaje,
//        );
        
    }
    
    /**
     * Eliminar un usuario 
     *
     * @Route("/delete/{id}", name="delete_usuario")
     * @Method("GET")
     */
    public function deleteUsusarioAction(Usuario $usuario)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser(); 
        
        $em = $this->getDoctrine()->getManager();
        $us = $em->getRepository('DGImpresionBundle:Usuario')->find($usuario->getId());
        $us->setEstado(FALSE);
        $em->merge($us);
        $em->flush();
        
        $dql = "SELECT p, u FROM DGImpresionBundle:Usuario u "
                . "JOIN u.persona p WHERE p.estado=:pestado "
                . "AND u.estado=:uestado AND u.id <> :usuario ";
        
        $usuarios = $em->createQuery($dql)
                   ->setParameter('pestado', 1)
                   ->setParameter('uestado', 1)
                   ->setParameter('usuario', $user->getId())
                   ->getResult();

        $promotion = $this->get('promotion_img')->searchPromotion();
        //var_dump($promotion);
        return $this->render('usuario/index.html.twig', array(
            'usuarios' => $usuarios,
            'promotion' => $promotion,
        ));
    }
    
    
}

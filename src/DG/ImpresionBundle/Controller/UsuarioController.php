<?php

namespace DG\ImpresionBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Usuario;
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
        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT p, u FROM DGImpresionBundle:Usuario u "
                . "JOIN u.persona p WHERE p.estado=:estado ";
        
        $usuarios = $em->createQuery($dql)
                   ->setParameter('estado', 1)
                   ->getResult();

        return $this->render('usuario/index.html.twig', array(
            'usuarios' => $usuarios,
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

        return $this->render('usuario/show.html.twig', array(
            'usuario' => $usuario,
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
            return $this->redirectToRoute('admin_usuario_index');
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
}

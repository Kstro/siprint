<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Tarjeta;
use DG\ImpresionBundle\Form\TarjetaType;

/**
 * Tarjeta controller.
 *
 * @Route("/admin/credit-cards")
 */
class TarjetaController extends Controller
{
    /**
     * Lists all Tarjeta entities.
     *
     * @Route("/", name="admin_credit_cards_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuario= $this->get('security.token_storage')->getToken()->getUser();
        
        $tarjetas = $em->getRepository('DGImpresionBundle:Tarjeta')->findBy(array(
                                                                                'usuario' => $usuario
                                                                            ));

        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render('tarjeta/index.html.twig', array(
            'tarjetas' => $tarjetas,
            'promotion' => $promotion,
            'usuario' => $usuario,
        ));
    }

    /**
     * Creates a new Tarjeta entity.
     *
     * @Route("/new", name="admin_credit_cards_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $usuario= $this->get('security.token_storage')->getToken()->getUser();
        $tarjetum = new Tarjeta();
        $form = $this->createForm('DG\ImpresionBundle\Form\TarjetaType', $tarjetum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tarjetum->setUsuario($usuario);
            $em = $this->getDoctrine()->getManager();
            $em->persist($tarjetum);
            $em->flush();

            //return $this->redirectToRoute('admin_credit_cards_show', array('id' => $tarjeta->getId()));
            return $this->redirectToRoute('admin_credit_cards_index');
        }

        return $this->render('tarjeta/new.html.twig', array(
            'tarjetum' => $tarjetum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tarjeta entity.
     *
     * @Route("/{id}", name="admin_credit_cards_show")
     * @Method("GET")
     */
    public function showAction(Tarjeta $tarjetum)
    {
        $deleteForm = $this->createDeleteForm($tarjetum);

        return $this->render('tarjeta/show.html.twig', array(
            'tarjetum' => $tarjetum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tarjeta entity.
     *
     * @Route("/{id}/edit", name="admin_credit_cards_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tarjeta $tarjetum)
    {
        $deleteForm = $this->createDeleteForm($tarjetum);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\TarjetaType', $tarjetum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tarjetum);
            $em->flush();

            //return $this->redirectToRoute('admin_credit_cards_edit', array('id' => $tarjetum->getId()));
            return $this->redirectToRoute('admin_credit_cards_index');
        }

        return $this->render('tarjeta/edit.html.twig', array(
            'tarjetum' => $tarjetum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tarjeta entity.
     *
     * @Route("/{id}", name="admin_credit_cards_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tarjeta $tarjetum)
    {
        $form = $this->createDeleteForm($tarjetum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tarjetum);
            $em->flush();
        }

        return $this->redirectToRoute('admin_credit_cards_index');
    }

    /**
     * Creates a form to delete a Tarjeta entity.
     *
     * @param Tarjeta $tarjetum The Tarjeta entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tarjeta $tarjetum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_credit_cards_delete', array('id' => $tarjetum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

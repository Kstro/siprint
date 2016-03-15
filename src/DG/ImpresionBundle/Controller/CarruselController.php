<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Carrusel;
use DG\ImpresionBundle\Form\CarruselType;

/**
 * Carrusel controller.
 *
 * @Route("/admin/carousel")
 */
class CarruselController extends Controller
{
    /**
     * Lists all Carrusel entities.
     *
     * @Route("/", name="admin_carousel_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $carrusels = $em->getRepository('DGImpresionBundle:Carrusel')->findAll();

        return $this->render('carrusel/index.html.twig', array(
            'carrusels' => $carrusels,
        ));
    }

    /**
     * Creates a new Carrusel entity.
     *
     * @Route("/new", name="admin_carousel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $carrusel = new Carrusel();
        $form = $this->createForm('DG\ImpresionBundle\Form\CarruselType', $carrusel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($carrusel);
            $em->flush();

            return $this->redirectToRoute('admin_carousel_show', array('id' => $carrusel->getId()));
        }

        return $this->render('carrusel/new.html.twig', array(
            'carrusel' => $carrusel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Carrusel entity.
     *
     * @Route("/{id}", name="admin_carousel_show")
     * @Method("GET")
     */
    public function showAction(Carrusel $carrusel)
    {
        $deleteForm = $this->createDeleteForm($carrusel);

        return $this->render('carrusel/show.html.twig', array(
            'carrusel' => $carrusel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Carrusel entity.
     *
     * @Route("/{id}/edit", name="admin_carousel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Carrusel $carrusel)
    {
        $deleteForm = $this->createDeleteForm($carrusel);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\CarruselType', $carrusel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($carrusel);
            $em->flush();

            return $this->redirectToRoute('admin_carousel_edit', array('id' => $carrusel->getId()));
        }

        return $this->render('carrusel/edit.html.twig', array(
            'carrusel' => $carrusel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Carrusel entity.
     *
     * @Route("/{id}", name="admin_carousel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Carrusel $carrusel)
    {
        $form = $this->createDeleteForm($carrusel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($carrusel);
            $em->flush();
        }

        return $this->redirectToRoute('admin_carousel_index');
    }

    /**
     * Creates a form to delete a Carrusel entity.
     *
     * @param Carrusel $carrusel The Carrusel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Carrusel $carrusel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_carousel_delete', array('id' => $carrusel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

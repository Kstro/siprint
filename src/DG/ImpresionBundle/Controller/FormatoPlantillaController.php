<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\FormatoPlantilla;
use DG\ImpresionBundle\Form\FormatoPlantillaType;

/**
 * FormatoPlantilla controller.
 *
 * @Route("/admin/formatoplantilla")
 */
class FormatoPlantillaController extends Controller
{
    /**
     * Lists all FormatoPlantilla entities.
     *
     * @Route("/", name="admin_formatoplantilla_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $formatoPlantillas = $em->getRepository('DGImpresionBundle:FormatoPlantilla')->findAll();

        return $this->render('formatoplantilla/index.html.twig', array(
            'formatoPlantillas' => $formatoPlantillas,
        ));
    }

    /**
     * Creates a new FormatoPlantilla entity.
     *
     * @Route("/new", name="admin_formatoplantilla_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $formatoPlantilla = new FormatoPlantilla();
        $form = $this->createForm('DG\ImpresionBundle\Form\FormatoPlantillaType', $formatoPlantilla);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($formatoPlantilla);
            $em->flush();

            return $this->redirectToRoute('admin_formatoplantilla_show', array('id' => $formatoplantilla->getId()));
        }

        return $this->render('formatoplantilla/new.html.twig', array(
            'formatoPlantilla' => $formatoPlantilla,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FormatoPlantilla entity.
     *
     * @Route("/{id}", name="admin_formatoplantilla_show")
     * @Method("GET")
     */
    public function showAction(FormatoPlantilla $formatoPlantilla)
    {
        $deleteForm = $this->createDeleteForm($formatoPlantilla);

        return $this->render('formatoplantilla/show.html.twig', array(
            'formatoPlantilla' => $formatoPlantilla,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FormatoPlantilla entity.
     *
     * @Route("/{id}/edit", name="admin_formatoplantilla_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FormatoPlantilla $formatoPlantilla)
    {
        $deleteForm = $this->createDeleteForm($formatoPlantilla);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\FormatoPlantillaType', $formatoPlantilla);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($formatoPlantilla);
            $em->flush();

            return $this->redirectToRoute('admin_formatoplantilla_edit', array('id' => $formatoPlantilla->getId()));
        }

        return $this->render('formatoplantilla/edit.html.twig', array(
            'formatoPlantilla' => $formatoPlantilla,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FormatoPlantilla entity.
     *
     * @Route("/{id}", name="admin_formatoplantilla_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FormatoPlantilla $formatoPlantilla)
    {
        $form = $this->createDeleteForm($formatoPlantilla);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($formatoPlantilla);
            $em->flush();
        }

        return $this->redirectToRoute('admin_formatoplantilla_index');
    }

    /**
     * Creates a form to delete a FormatoPlantilla entity.
     *
     * @param FormatoPlantilla $formatoPlantilla The FormatoPlantilla entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FormatoPlantilla $formatoPlantilla)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_formatoplantilla_delete', array('id' => $formatoPlantilla->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

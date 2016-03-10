<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Suscripcion;
use DG\ImpresionBundle\Form\SuscripcionType;

/**
 * Suscripcion controller.
 *
 * @Route("/")
 */
class SuscripcionController extends Controller
{
    /**
     * Lists all Suscripcion entities.
     *
     * @Route("/suscripcion/all", name="suscripcion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $suscripcions = $em->getRepository('DGImpresionBundle:Suscripcion')->findAll();

        return $this->render('suscripcion/index.html.twig', array(
            'suscripcions' => $suscripcions,
        ));
    }

    /**
     * Creates a new Suscripcion entity.
     *
     * @Route("/contact-us", name="dg_general_contact")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $suscripcion = new Suscripcion();
        $form = $this->createForm('DG\ImpresionBundle\Form\SuscripcionType', $suscripcion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($suscripcion);
            $em->flush();
            
            $this->get('envio_correo')->sendEmail("anthony@digitalitygarage.com", "", "", "",
                "
                    <table style=\"width: 540px; margin: 0 auto;\">
                      <tr>
                        <td class=\"panel\" style=\"border-radius:4px;border:1px #dceaf5 solid; color:#000 ; font-size:11pt;font-family:proxima_nova,'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'; padding: 30px !important; background-color: #FFF;\">
                        <center>
                          <img style=\"width:50%;\" src=\"http://expressionsprint.com/img/logo.jpg\">
                        </center>
                            <p>" . $suscripcion->getMensaje() . "</p>    
                        </td>
                        <td class=\"expander\"></td>
                      </tr>
                    </table>
                ");

            return $this->redirectToRoute('dg_general_contact');
        }

        return $this->render('General/contact.html.twig', array(
            'suscripcion' => $suscripcion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Suscripcion entity.
     *
     * @Route("/suscripcion/{id}", name="suscripcion_show")
     * @Method("GET")
     */
    public function showAction(Suscripcion $suscripcion)
    {
        $deleteForm = $this->createDeleteForm($suscripcion);

        return $this->render('suscripcion/show.html.twig', array(
            'suscripcion' => $suscripcion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Suscripcion entity.
     *
     * @Route("/suscripcion/{id}/edit", name="suscripcion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Suscripcion $suscripcion)
    {
        $deleteForm = $this->createDeleteForm($suscripcion);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\SuscripcionType', $suscripcion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($suscripcion);
            $em->flush();

            return $this->redirectToRoute('suscripcion_edit', array('id' => $suscripcion->getId()));
        }

        return $this->render('suscripcion/edit.html.twig', array(
            'suscripcion' => $suscripcion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Suscripcion entity.
     *
     * @Route("/suscripcion/{id}", name="suscripcion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Suscripcion $suscripcion)
    {
        $form = $this->createDeleteForm($suscripcion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($suscripcion);
            $em->flush();
        }

        return $this->redirectToRoute('suscripcion_index');
    }

    /**
     * Creates a form to delete a Suscripcion entity.
     *
     * @param Suscripcion $suscripcion The Suscripcion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Suscripcion $suscripcion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('suscripcion_delete', array('id' => $suscripcion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

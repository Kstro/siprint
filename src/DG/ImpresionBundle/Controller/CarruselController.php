<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Carrusel;
use DG\ImpresionBundle\Form\CarruselType;
use Doctrine\Common\Collections\ArrayCollection;

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
        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render('carrusel/index.html.twig', array(
            'carrusels' => $carrusels,
            'promotion' => $promotion,
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
            
            $originalImagenes= new ArrayCollection();
            $path  = $this->getRequest()->server->get('DOCUMENT_ROOT').'/siprint/web/Photos/Carousels/';
            $path2 = $this->container->getParameter('photo.carousel');    
            
            // Create an ArrayCollection of the current Tag objects in the database
            $i=0;
            $originalImagenes = $carrusel->getPlacas();
            foreach ($carrusel->getPlacas() as $row) {
                
                if($row->getFile()!=null){
                    $file_path = $path.'/'.$row->getImagen();
                    
                    if(file_exists($file_path) && $row->getImagen()!="") unlink($file_path);
                    
                    $fecha = date('Y-m-d His');
                    $extension = $row->getFile()->getClientOriginalExtension();
                    $nombreArchivo = "carousel-".$i."-".$fecha.".".$extension;

                    $row->setImagen($nombreArchivo);
                    $row->getFile()->move($path2,$nombreArchivo);
                    
                    $em->persist($row);
                    //$em->flush();
                    $i++;
                }            
            }
        
            foreach ($originalImagenes as $row) {
                $file_path = $path.'/'.$row->getImagen();
                if (false === $carrusel->getPlacas()->contains($row)) {
                    unlink($file_path);
                    
                    // if you wanted to delete the Tag entirely, you can also do that
                    $em->remove($row);
                    $em->flush();
                }
            }
            
            //$em->persist($carrusel);
            $em->flush();
            
            return $this->redirect($this->generateUrl('admin_carousel_index'));
        }

        return $this->render('carrusel/edit.html.twig', array(
            'carrusel' => $carrusel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'placas'=>$carrusel->getPlacas(),
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
    
    /**
    * Ajax utilizado para buscar informacion de un carrusel
    *  
    * @Route("/busqueda-carrusel-select/data", name="busqueda_carrusel_select")
    */
    public function busquedaCarruselAction(Request $request)
    {
        $busqueda = $request->query->get('q');
        
        $em = $this->getDoctrine()->getEntityManager();
        $dql = "SELECT ca.id carruselid, ca.nombre "
                        . "FROM DGImpresionBundle:Carrusel ca "
                        . "WHERE upper(ca.nombre) LIKE upper(:busqueda) "
                        . "ORDER BY ca.nombre ASC ";
        
        $carrusel['data'] = $em->createQuery($dql)
                ->setParameters(array('busqueda'=>"%".$busqueda."%"))
                ->setMaxResults( 10 )
                ->getResult();
        
        return new Response(json_encode($carrusel));
    }
}

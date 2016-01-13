<?php

namespace DG\ImpresionBundle\Controller;

//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\Query\ResultSetMapping;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DG\ImpresionBundle\Entity\Categoria;
use DG\ImpresionBundle\Form\CategoriaType;

/**
 * Categoria controller.
 *
 * @Route("/")
 */
class CategoriaController extends Controller
{
    /**
     * Lists all Categoria entities.
     *
     * @Route("/admin/products", name="categoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorias = $em->getRepository('DGImpresionBundle:Categoria')->findAll();

        return $this->render('categoria/index.html.twig', array(
            'categorias' => $categorias,
        ));
    }
    
    /**
     * Lists all Categoria entities.
     *
     * @Route("/products", name="products_list")
     * @Method("GET")
     */
    public function productsListAction()
    {
        $em = $this->getDoctrine()->getManager();

        $types = $em->getRepository('DGImpresionBundle:Categoria')->findBy(array('categoria' => NULL));
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NOT NULL ";
        
        $categorias = $em->createQuery($dql)
                   ->getResult();
        
        return $this->render('categoria/productslist.html.twig', array(
            'types' => $types,
            'categorias' => $categorias,
            'registro'=>null
        ));
    }
    
    /**
     * Creates a new Categoria entity.
     *
     * @Route("/admin/products/new", name="categoria_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categorium = new Categoria();
        $form = $this->createForm('DG\ImpresionBundle\Form\CategoriaType', $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorium);
            $em->flush();
            
            if($categorium->getFile()!=null){
                $path = $this->container->getParameter('photo.promotion');

                $fecha = date('Y-m-d His');
                $extension = $categorium->getFile()->getClientOriginalExtension();
                $nombreArchivo = "promotion_".$fecha.".".$extension;
                $em->persist($categorium);
                $em->flush();
                //var_dump($path.$nombreArchivo);

                $categorium->setImagen($nombreArchivo);
                $categorium->getFile()->move($path,$nombreArchivo);
                $em->persist($categorium);
                $em->flush();
            }

//            return $this->redirectToRoute('categoria_show', array('id' => $categorium->getId()));
            return $this->redirectToRoute('categoria_index');
        }

        return $this->render('categoria/new.html.twig', array(
            'categorium' => $categorium,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Categoria entity.
     *
     * @Route("/products/{id}", name="categoria_show")
     * @Method("GET")
     */
    public function showAction(Categoria $categorium)
    {
        $deleteForm = $this->createDeleteForm($categorium);

        return $this->render('categoria/show.html.twig', array(
            'categorium' => $categorium,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Categoria entity.
     *
     * @Route("/admin/products/{id}/edit", name="categoria_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Categoria $categorium)
    {
        $deleteForm = $this->createDeleteForm($categorium);
        $editForm = $this->createForm('DG\ImpresionBundle\Form\CategoriaType', $categorium);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorium);
            $em->flush();
            
            if($categorium->getFile()!=null){
                $path = $this->container->getParameter('photo.promotion');

                $fecha = date('Y-m-d His');
                $extension = $categorium->getFile()->getClientOriginalExtension();
                $nombreArchivo = "promotion_".$fecha.".".$extension;
                $em->persist($categorium);
                $em->flush();
                //var_dump($path.$nombreArchivo);

                $categorium->setImagen($nombreArchivo);
                $categorium->getFile()->move($path,$nombreArchivo);
                $em->persist($categorium);
                $em->flush();
            }

//            return $this->redirectToRoute('categoria_edit', array('id' => $categorium->getId()));
            return $this->redirectToRoute('categoria_index');
        }

        return $this->render('categoria/edit.html.twig', array(
            'categorium' => $categorium,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Categoria entity.
     *
     * @Route("/admin/products/{id}", name="categoria_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Categoria $categorium)
    {
        $form = $this->createDeleteForm($categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorium);
            $em->flush();
        }

        return $this->redirectToRoute('categoria_index');
    }

    /**
     * Creates a form to delete a Categoria entity.
     *
     * @param Categoria $categorium The Categoria entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Categoria $categorium)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categoria_delete', array('id' => $categorium->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
    * Ajax utilizado para buscar informacion del producto
    *  
    * @Route("/product/get", name="get_products")
    */
    public function productInfoAction()
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
            $id = $this->get('request')->request->get('id');
             
            $em = $this->getDoctrine()->getManager();            
            $cat = $em->getRepository('DGImpresionBundle:Categoria')->find($id);
            
            $rsm = new ResultSetMapping();
            $sql = "select p.id as idParam "
                    . "p.nombre as parametro, "
                    . "dp.nombre as valorParam, "
                    . "dp.valor as precio "
                    . "from categoria_parametro cp "
                    . "inner join parametro p on cp.parametro_id = p.id "
                    . "inner join detalle_parametro dp on p.id = dp.parametro "
                    . "where cp.categoria_id = ? ";
            
            $rsm->addScalarResult('idParam','idParam');
            $rsm->addScalarResult('parametro','parametro');
            $rsm->addScalarResult('valorParam','valorParam');
            $rsm->addScalarResult('precio','precio');
            
            $query = $em->createNativeQuery($sql, $rsm);
            $query->setParameter(1, $id);
            $param = $query->getResult();
             
            
//            $idproduct = $cat->getId();
//            $nombre = $cat->getNombre();
//            $imagen = $cat->getImagen();
//            $categoria = $cat->getCategoria()->getNombre();
            
            $response = new JsonResponse();
            $response->setData(array(
                                'idproduct' => $cat->getId(),
                                'nombre' => $cat->getNombre(),
                                'imagen' => $cat->getImagen(),
                                'categoria' => $cat->getCategoria()->getNombre(),
                                'parametros' => $param
                    )); 
            
            return $response; 
        } else {    
            return new Response('0');              
        }  
    }
}

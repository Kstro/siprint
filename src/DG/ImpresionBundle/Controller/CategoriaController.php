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
use Symfony\Component\HttpFoundation\Cookie;
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

        //$categorias = $em->getRepository('DGImpresionBundle:Categoria')->findAll();
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "INNER JOIN p.categoria cat "
                . "WHERE p.categoria IS NOT NULL "
                . "AND p.estado = 1 AND cat.estado = 1 AND p.categoria <> :tshirt ";
        
        $categorias = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();

        $atributos = $em->getRepository('DGImpresionBundle:CategoriaParametro')->findAll();
        
        $promotion = $this->get('promotion_img')->searchPromotion();
        
//        $types = $em->getRepository('DGImpresionBundle:Categoria')->findBy(array('categoria' => NULL,
//                                                                                 'estado'    => 1
//                                                                                ));
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NULL "
                . "AND p.id <> :tshirt "
                . "AND p.estado = 1 ";
        
        $types = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria = :tshirt "
                . "AND p.estado = 1 ";
        
        $tshirts = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();
        
        return $this->render('categoria/index.html.twig', array(
            'categorias' => $categorias,
            'types' => $types,
            'tshirts' => $tshirts,
            'atributos' => $atributos,
            'promotion' => $promotion,
        ));
    }
    
    /**
     * Lists all Categoria entities.
     *
     * @Route("/admin/t-shirt-printing", name="admin_tshirtprinting_index")
     * @Method("GET")
     */
    public function indexShirtAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$categorias = $em->getRepository('DGImpresionBundle:Categoria')->findAll();
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "INNER JOIN p.categoria cat "
                . "WHERE p.categoria IS NOT NULL "
                . "AND p.estado = 1 AND cat.estado = 1 AND p.categoria <> :tshirt ";
        
        $categorias = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();

        $atributos = $em->getRepository('DGImpresionBundle:CategoriaParametro')->findAll();
        
        $promotion = $this->get('promotion_img')->searchPromotion();
        
//        $types = $em->getRepository('DGImpresionBundle:Categoria')->findBy(array('categoria' => NULL,
//                                                                                 'estado'    => 1
//                                                                                ));
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NULL "
                . "AND p.id <> :tshirt "
                . "AND p.estado = 1 ";
        
        $types = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria = :tshirt "
                . "AND p.estado = 1 ";
        
        $tshirts = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();
        
        return $this->render('categoria/index_tshirt.html.twig', array(
            'categorias' => $categorias,
            'types' => $types,
            'tshirts' => $tshirts,
            'atributos' => $atributos,
            'promotion' => $promotion,
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

        //$types = $em->getRepository('DGImpresionBundle:Categoria')->findBy(array('categoria' => NULL,
        //                                                                         'estado'    => 1
        //                                                                        ));
//        var_dump($_COOKIE);
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NULL "
                . "AND p.id <> :tshirt "
                . "AND p.estado = 1 ";
        
        $types = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();
        
        
         $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "INNER JOIN p.categoria cat "
                . "WHERE p.categoria IS NOT NULL "
                . "AND p.estado = 1 AND cat.estado = 1 AND p.categoria <> :tshirt ";
        
        $categorias = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();
        
        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render('categoria/productslist.html.twig', array(
            'types' => $types,
            'categorias' => $categorias,
            'promotion' => $promotion,
            'registro'=>null
        ));
    }
    
    /**
     * Filtro de categoria de productos
     *
     * @Route("/filter-products/{id}", name="filter_products_list")
     * @Method("GET")
     */
    public function filterProductsAction(Categoria $categorium)
    {
        $em = $this->getDoctrine()->getManager();

        //$types = $em->getRepository('DGImpresionBundle:Categoria')->findBy(array('categoria' => NULL,
        //                                                                         'estado'    => 1
        //                                                                        ));

        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NULL "
                . "AND p.id <> :tshirt "
                . "AND p.estado = 1 ";
        
        $types = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();

        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NOT NULL "
                . "AND p.categoria <> :tshirt "
                . "AND p.estado = 1 ";
        
        $categorias = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria = :product "
                . "AND p.estado = 1 ";
        
        $products = $categorias = $em->createQuery($dql)
                   ->setParameters(array('product' => $categorium->getId()))
                   ->getResult();
        
        $promotion = $this->get('promotion_img')->searchPromotion();
        
        return $this->render('categoria/filter_products_list.html.twig', array(
            'types'      => $types,
            'categorias' => $categorias,
            'products'   => $products,
            'promotion'  => $promotion,
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
            $parameters = $request->request->all();
            
            $em = $this->getDoctrine()->getManager();
            $categorium->setEstado(1);
            $em->persist($categorium);
            $em->flush();
            
            if($categorium->getFile()!=null){
                $path = $this->container->getParameter('photo.promotion');

                $fecha = date('Y-m-d His');
                $extension = $categorium->getFile()->getClientOriginalExtension();
                $nombreArchivo = "product_".$fecha.".".$extension;
                $em->persist($categorium);
                $em->flush();
                //var_dump($path.$nombreArchivo);

                $categorium->setImagen($nombreArchivo);
                $categorium->getFile()->move($path,$nombreArchivo);
                $em->persist($categorium);
                $em->flush();
                
                
                //$em->merge($categorium);
                //$em->flush();
            }
            
            if(isset($parameters['chk'])){
                $detalle = 0;
                foreach ($parameters['chk'] as $key => $value) {
                    $categoriaParametro = new \DG\ImpresionBundle\Entity\CategoriaParametro;
                    $opcionProducto = new \DG\ImpresionBundle\Entity\OpcionProducto;
                    $costo = $parameters['costo'][$value];
                    $detalleParametro = $em->getRepository('DGImpresionBundle:DetalleParametro')->find($value);

                    if($detalle != $detalleParametro->getParametro()->getId()){
                        $detalle = $detalleParametro->getParametro()->getId();

                        $categoriaParametro->setCategoria($categorium);
                        $categoriaParametro->setParametro($detalleParametro->getParametro());
                        $em->persist($categoriaParametro);
                        $em->flush();
                    }

                    $opcionProducto->setCosto($costo);
                    $opcionProducto->setCategoria($categorium);
                    $opcionProducto->setDetalleParametro($detalleParametro);

                    $em->persist($opcionProducto);
                    $em->flush();
                }
            }
//            return $this->redirectToRoute('categoria_show', array('id' => $categorium->getId()));
            return $this->redirectToRoute('categoria_index');
        }
        
        $em = $this->getDoctrine()->getManager();
        //$atributos = $em->getRepository('DGImpresionBundle:Parametro')->findAll();
        //$atributos = $em->getRepository('DGImpresionBundle:Parametro')->findBy(array('estado' => 1));
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Parametro p "
                . "WHERE p.id <> 1 AND p.id <> 2 AND p.estado = 1";
        
        $atributos = $em->createQuery($dql)
                   ->getResult();
        
        $dql = "SELECT dp.id iddp, dp.nombre nomdp, p.id idpar, p.nombre nompar "
                . "FROM DGImpresionBundle:DetalleParametro dp "
                . "INNER JOIN dp.parametro p ";
        
        $attr_val = $em->createQuery($dql)
                   ->getResult();
       
        return $this->render('categoria/new.html.twig', array(
            'categorium' => $categorium,
            'atributos' => $atributos,
            'attr_val' => $attr_val,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Creates a new Categoria entity.
     *
     * @Route("/admin/t-shirt-printing/new", name="tshirt_printing_new")
     * @Method({"GET", "POST"})
     */
    public function newTShirtPrintingAction(Request $request)
    {
        $categorium = new Categoria();
        $form = $this->createForm('DG\ImpresionBundle\Form\TShirtPrintingType', $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parameters = $request->request->all();
            
            $em = $this->getDoctrine()->getManager();
            $categoria = $em->getRepository('DGImpresionBundle:Categoria')->find(38);
            $categorium->setCategoria($categoria);
            $categorium->setEstado(1);
            $em->persist($categorium);
            $em->flush();
            
            if($categorium->getFile()!=null){
                $path = $this->container->getParameter('photo.promotion');

                $fecha = date('Y-m-d His');
                $extension = $categorium->getFile()->getClientOriginalExtension();
                $nombreArchivo = "product_".$fecha.".".$extension;
                $em->persist($categorium);
                $em->flush();
                //var_dump($path.$nombreArchivo);

                $categorium->setImagen($nombreArchivo);
                $categorium->getFile()->move($path,$nombreArchivo);
                $em->persist($categorium);
                $em->flush();
                
                
                //$em->merge($categorium);
                //$em->flush();
            }
            
            if(isset($parameters['chk'])){
                $detalle = 0;
                foreach ($parameters['chk'] as $key => $value) {
                    $categoriaParametro = new \DG\ImpresionBundle\Entity\CategoriaParametro;
                    $opcionProducto = new \DG\ImpresionBundle\Entity\OpcionProducto;
                    $costo = $parameters['costo'][$value];
                    $detalleParametro = $em->getRepository('DGImpresionBundle:DetalleParametro')->find($value);

                    if($detalle != $detalleParametro->getParametro()->getId()){
                        $detalle = $detalleParametro->getParametro()->getId();

                        $categoriaParametro->setCategoria($categorium);
                        $categoriaParametro->setParametro($detalleParametro->getParametro());
                        $em->persist($categoriaParametro);
                        $em->flush();
                    }

                    $opcionProducto->setCosto($costo);
                    $opcionProducto->setCategoria($categorium);
                    $opcionProducto->setDetalleParametro($detalleParametro);

                    $em->persist($opcionProducto);
                    $em->flush();
                }
            }
//            return $this->redirectToRoute('categoria_show', array('id' => $categorium->getId()));
            return $this->redirectToRoute('admin_tshirtprinting_index');
        }
        
        $em = $this->getDoctrine()->getManager();
        //$atributos = $em->getRepository('DGImpresionBundle:Parametro')->findAll();
        //$atributoCant = $em->getRepository('DGImpresionBundle:Parametro')->findBy(array('id' => 1));
        //$atributoTalla = $em->getRepository('DGImpresionBundle:Parametro')->findBy(array('id' => 2));
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Parametro p "
                . "WHERE p.id = 1 OR p.id = 2 ";
        
        $atributos = $em->createQuery($dql)
                   ->getResult();
        
        $dql2 = "SELECT dp.id iddp, dp.nombre nomdp, p.id idpar, p.nombre nompar "
                . "FROM DGImpresionBundle:DetalleParametro dp "
                . "INNER JOIN dp.parametro p "
                . "WHERE p.id = 1 OR p.id = 2 ";
        
        $attr_val = $em->createQuery($dql2)
                   ->getResult();
       
        return $this->render('categoria/new_tshirt.html.twig', array(
            'categorium' => $categorium,
            //'atributoCant' => $atributoCant,
            'atributos' => $atributos,
            'attr_val' => $attr_val,
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
        $em = $this->getDoctrine()->getManager();
        //$types = $em->getRepository('DGImpresionBundle:Categoria')->findBy(array('categoria' => NULL, 'estado' => 1));
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NULL "
                . "AND p.id <> :tshirt "
                . "AND p.estado = 1 ";
        
        $types = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NOT NULL AND p.estado = 1 ";
        
        $categorias = $em->createQuery($dql)
                   ->getResult();
        
        $rsm = new ResultSetMapping();
        $sql = "select p.id as idParam, p.nombre as parametro "
                . "from categoria_parametro cp inner join parametro p on cp.parametro = p.id "
                . "where cp.categoria = ? ";

        $rsm->addScalarResult('idParam','idParam');
        $rsm->addScalarResult('parametro','parametro');
        $query = $em->createNativeQuery($sql, $rsm);
        $query->setParameter(1, $categorium->getId());
        $atributos = $query->getResult();
        
        $opciones = array();
        foreach ($atributos as $value) {
            $rsm2 = new ResultSetMapping();
            $sql = "select dp.parametro as parametro, op.id as idValorParam, dp.nombre as valorParam, op.costo as precio "
                    . "from detalle_parametro dp inner join opcion_producto op on dp.id = op.detalle_parametro "
                    . "left outer join tipo_parametro tp on dp.tipo_parametro = tp.id "
                    . "where dp.parametro = ? and op.categoria = ? ";

            $rsm2->addScalarResult('parametro','parametro');
            $rsm2->addScalarResult('idValorParam','idValorParam');
            $rsm2->addScalarResult('valorParam','valorParam');
            $rsm2->addScalarResult('precio','precio');
            $rsm2->addScalarResult('tipo','tipo');
            $query2 = $em->createNativeQuery($sql, $rsm2);
            $query2->setParameter(1, $value['idParam']);
            $query2->setParameter(2, $categorium->getId());
            $param = $query2->getResult(); 
            array_push($opciones, $param);
        }
        //var_dump($atributos);
        //var_dump($opciones);
        
        $promotion = $this->get('promotion_img')->searchPromotion();
        $deleteForm = $this->createDeleteForm($categorium);

        return $this->render('categoria/show.html.twig', array('categorium' => $categorium, 'opciones' => $opciones, 'delete_form' => $deleteForm->createView(), 'types' => $types, 'categorias' => $categorias, 'atributos' => $atributos, 'promotion' => $promotion, 'registro'=>null ));
    }
    
    /**
     * Finds and displays a Categoria entity.
     *
     * @Route("/t-shirt-printing/{id}", name="t_shirt_show")
     * @Method("GET")
     */
    public function showTshirtAction(Categoria $categorium)
    {
        $em = $this->getDoctrine()->getManager();
        $types = $em->getRepository('DGImpresionBundle:Categoria')->findBy(array('categoria' => NULL, 'estado' => 1));
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NOT NULL AND p.estado = 1 ";
        
        $categorias = $em->createQuery($dql)
                   ->getResult();
        
        $rsm = new ResultSetMapping();
        $sql = "select p.id as idParam, p.nombre as parametro "
                . "from categoria_parametro cp inner join parametro p on cp.parametro = p.id "
                . "where cp.categoria = ? ";

        $rsm->addScalarResult('idParam','idParam');
        $rsm->addScalarResult('parametro','parametro');
        $query = $em->createNativeQuery($sql, $rsm);
        $query->setParameter(1, $categorium->getId());
        $atributos = $query->getResult();
        
        $opciones = array();
        foreach ($atributos as $value) {
//            var_dump($value);
            $rsm2 = new ResultSetMapping();
            $sql = "select distinct op.id as idValorParam, dp.parametro as parametro, dp.nombre as valorParam, op.costo as precio "
                    . "from detalle_parametro dp inner join opcion_producto op on dp.id = op.detalle_parametro "
                    . "left outer join tipo_parametro tp on dp.tipo_parametro = tp.id "
                    . "where dp.parametro = ? and op.categoria = ? ";

            $rsm2->addScalarResult('parametro','parametro');
            $rsm2->addScalarResult('idValorParam','idValorParam');
            $rsm2->addScalarResult('valorParam','valorParam');
            $rsm2->addScalarResult('precio','precio');
            $rsm2->addScalarResult('tipo','tipo');
            $query2 = $em->createNativeQuery($sql, $rsm2);
            $query2->setParameter(1, $value['idParam']);
            $query2->setParameter(2, $categorium->getId());
            $param = $query2->getResult(); 
            array_push($opciones, $param);
        }
        //var_dump($opciones);
        $promotion = $this->get('promotion_img')->searchPromotion();
        $deleteForm = $this->createDeleteForm($categorium);
        
        

        return $this->render('categoria/show_tshirt.html.twig', array('categorium' => $categorium, 'opciones' => $opciones, 'delete_form' => $deleteForm->createView(), 'types' => $types, 'categorias' => $categorias, 'atributos' => $atributos, 'promotion' => $promotion, 'registro'=>null ));
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
                
                if(isset($parameters['chk'])){
                    $detalle = 0;
                    foreach ($parameters['chk'] as $key => $value) {
                        
                        $categoriaParametro = new \DG\ImpresionBundle\Entity\CategoriaParametro;
                        $opcionProducto = new \DG\ImpresionBundle\Entity\OpcionProducto;
                        $costo = $parameters['costo'][$value];
                        $detalleParametro = $em->getRepository('DGImpresionBundle:DetalleParametro')->find($value);

                        if($detalle != $detalleParametro->getParametro()->getId()){
                            $detalle = $detalleParametro->getParametro()->getId();

                            $categoriaParametro->setCategoria($categorium);
                            $categoriaParametro->setParametro($detalleParametro->getParametro());
                            $em->persist($categoriaParametro);
                            $em->flush();
                        }

                        $opcionProducto->setCosto($costo);
                        $opcionProducto->setCategoria($categorium);
                        $opcionProducto->setDetalleParametro($detalleParametro);

                        $em->persist($opcionProducto);
                        $em->flush();
                    }
                }
                
            }

//            return $this->redirectToRoute('categoria_edit', array('id' => $categorium->getId()));
            return $this->redirectToRoute('categoria_index');
        }

        $em = $this->getDoctrine()->getManager();
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Parametro p "
                . "WHERE p.id <> 1 AND p.id <> 2 AND p.estado = 1";
        
        $atributos = $em->createQuery($dql)
                   ->getResult();
        
        $dql = "SELECT dp.id iddp, dp.nombre nomdp, p.id idpar, p.nombre nompar "
                . "FROM DGImpresionBundle:DetalleParametro dp "
                . "INNER JOIN dp.parametro p "
                . "WHERE p.id <> 1 AND p.id <> 2 AND p.estado = 1";
        
        $attr_val = $em->createQuery($dql)
                   ->getResult();
        //   var_dump($attr_val);
        //$prod = $em->getRepository('DGImpresionBundle:Categoria')->find($categorium->getId());
        
        $rsm = new ResultSetMapping();
        $sql = "select p.id as idParam, p.nombre as parametro "
                . "from categoria_parametro cp inner join parametro p on cp.parametro = p.id "
                . "where cp.categoria = ? ";

        $rsm->addScalarResult('idParam','idParam');
        $rsm->addScalarResult('parametro','parametro');
        $query = $em->createNativeQuery($sql, $rsm);
        $query->setParameter(1, $categorium->getId());
        $atributes = $query->getResult();
        
        $opciones = array();
        foreach ($atributes as $value) {
            $rsm2 = new ResultSetMapping();
            $sql = "select dp.parametro as parametro, dp.id as idValorParam, dp.nombre as valorParam, op.costo as precio "
                    . "from detalle_parametro dp inner join opcion_producto op on dp.id = op.detalle_parametro "
                    . "left outer join tipo_parametro tp on dp.tipo_parametro = tp.id "
                    . "where dp.parametro = ? and op.categoria = ? ";

            $rsm2->addScalarResult('parametro','parametro');
            $rsm2->addScalarResult('idValorParam','idValorParam');
            $rsm2->addScalarResult('valorParam','valorParam');
            $rsm2->addScalarResult('precio','precio');
            $rsm2->addScalarResult('tipo','tipo');
            $query2 = $em->createNativeQuery($sql, $rsm2);
            $query2->setParameter(1, $value['idParam']);
            $query2->setParameter(2, $categorium->getId());
            $param = $query2->getResult(); 
            array_push($opciones, $param);
        }
        //var_dump($opciones);
        return $this->render('categoria/edit.html.twig', array(
            'categorium' => $categorium,
            'opciones' => $opciones,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'atributos' => $atributos,
            'atributes' => $atributes,
            'attr_val' => $attr_val,
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
     * Eliminar un producto de t-shirt
     *
     * @Route("/admin/delete/t-shirt/{id}", name="delete_tshirt")
     * @Method("GET")
     */
    public function deleteTShirtAction(Categoria $categorium)
    {
        $em = $this->getDoctrine()->getManager();
        $producto = $em->getRepository('DGImpresionBundle:Categoria')->find($categorium->getId());
        
        $producto->setEstado(FALSE);
//        var_dump($producto);
//        die();
        
        $em->merge($producto);
        $em->flush();
        
//        var_dump($producto);
//        die();
        
         $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "INNER JOIN p.categoria cat "
                . "WHERE p.categoria IS NOT NULL "
                . "AND p.estado = 1 AND cat.estado = 1 AND p.categoria <> :tshirt ";
        
        $categorias = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();

        $atributos = $em->getRepository('DGImpresionBundle:CategoriaParametro')->findAll();
        
        $promotion = $this->get('promotion_img')->searchPromotion();
        
//        $types = $em->getRepository('DGImpresionBundle:Categoria')->findBy(array('categoria' => NULL,
//                                                                                 'estado'    => 1
//                                                                                ));
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NULL "
                . "AND p.id <> :tshirt "
                . "AND p.estado = 1 ";
        
        $types = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria = :tshirt "
                . "AND p.estado = 1 ";
        
        $tshirts = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();
        
        return $this->render('categoria/index_tshirt.html.twig', array(
            'categorias' => $categorias,
            'types' => $types,
            'tshirts' => $tshirts,
            'atributos' => $atributos,
            'promotion' => $promotion,
        ));
    }
    
    /**
     * Eliminar un producto, categoria o t-shirt
     *
     * @Route("/admin/delete/product/{id}", name="delete_categoria")
     * @Method("GET")
     */
    public function deleteProductsAction(Categoria $categorium)
    {
        $em = $this->getDoctrine()->getManager();
        $producto = $em->getRepository('DGImpresionBundle:Categoria')->find($categorium->getId());
        
        $producto->setEstado(FALSE);
//        var_dump($producto);
//        die();
        
        $em->merge($producto);
        $em->flush();
        
//        var_dump($producto);
//        die();
        
         $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "INNER JOIN p.categoria cat "
                . "WHERE p.categoria IS NOT NULL "
                . "AND p.estado = 1 AND cat.estado = 1 AND p.categoria <> :tshirt ";
        
        $categorias = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();

        $atributos = $em->getRepository('DGImpresionBundle:CategoriaParametro')->findAll();
        
        $promotion = $this->get('promotion_img')->searchPromotion();
        
//        $types = $em->getRepository('DGImpresionBundle:Categoria')->findBy(array('categoria' => NULL,
//                                                                                 'estado'    => 1
//                                                                                ));
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria IS NULL "
                . "AND p.id <> :tshirt "
                . "AND p.estado = 1 ";
        
        $types = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();
        
        $dql = "SELECT p "
                . "FROM DGImpresionBundle:Categoria p "
                . "WHERE p.categoria = :tshirt "
                . "AND p.estado = 1 ";
        
        $tshirts = $em->createQuery($dql)
                   ->setParameters(array('tshirt' => 38))
                   ->getResult();
        
        return $this->render('categoria/index.html.twig', array(
            'categorias' => $categorias,
            'types' => $types,
            'tshirts' => $tshirts,
            'atributos' => $atributos,
            'promotion' => $promotion,
        ));
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
            $sql = "select p.id as idParam, "
                    . "p.nombre as parametro "
                    . "from categoria_parametro cp "
                    . "inner join parametro p on cp.parametro_id = p.id "
                    . "where cp.categoria_id = ? ";
            
            $rsm->addScalarResult('idParam','idParam');
            $rsm->addScalarResult('parametro','parametro');
            //var_dump($cat);
            $query = $em->createNativeQuery($sql, $rsm);
            $query->setParameter(1, $id);
            $param = $query->getResult();
            
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
    
    /**
    * Ajax utilizado para buscar informacion del producto
    *  
    * @Route("/product-store/get", name="get_products_store")
    */
    public function productInfoStoreAction()
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
            $id = $this->get('request')->request->get('id');
            $code = $this->get('request')->request->get('code');
            
            $em = $this->getDoctrine()->getManager();            
            $cat = $em->getRepository('DGImpresionBundle:Categoria')->find($id);
            
            $promo = $em->getRepository('DGImpresionBundle:Promocion')->findOneBy(array('codigo' => $code));
            $porcentaje = 0;
            
            if( $promo != NULL && $code != '' ){
                $porcentaje = $promo->getPorcentaje();
            } 
            
            $rsm = new ResultSetMapping();
            $sql = "select p.id as idParam, "
                    . "p.nombre as parametro "
                    . "from categoria_parametro cp "
                    . "inner join parametro p on cp.parametro = p.id "
                    . "where cp.categoria = ? ";
            
            $rsm->addScalarResult('idParam','idParam');
            $rsm->addScalarResult('parametro','parametro');
            
            $query = $em->createNativeQuery($sql, $rsm);
            $query->setParameter(1, $id);
            $param = $query->getResult();
            
            $response = new JsonResponse();
            $response->setData(array(
                                'idproduct' => $cat->getId(),
                                'nombre' => $cat->getNombre(),
                                'imagen' => $cat->getImagen(),
                                'categoria' => $cat->getCategoria()->getNombre(),
                                'parametros' => $param,
                                'porcentaje' => $porcentaje
                    )); 
            
            return $response; 
        } else {    
            return new Response('0');              
        }  
    }
    
    /**
    * Ajax utilizado para buscar informacion de los atributos del producto
    *  
    * @Route("/attributes/get", name="get_attributes_info")
    */
    public function attributesInfoAction()
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
            $id = $this->get('request')->request->get('id');
            $prod = $this->get('request')->request->get('cat');
             
            $em = $this->getDoctrine()->getManager();            
            $cat = $em->getRepository('DGImpresionBundle:Categoria')->find($id);
            
            $rsm = new ResultSetMapping();
            $sql = "select dp.parametro as parametro, "
                    . "dp.id as idValorParam, "
                    . "dp.nombre as valorParam, "
                    . "dp.valor as precio, "
                    . "tp.nombre as tipo, "
                    . "op.id as idValor "
                    . "from opcion_producto op inner join detalle_parametro dp on op.detalle_parametro = dp.id "
                    . "left outer join tipo_parametro tp on dp.tipo_parametro = tp.id "
                    . "where dp.parametro = ? and op.categoria = ? ";
            
            $rsm->addScalarResult('idValor','idValor');
            $rsm->addScalarResult('parametro','parametro');
            $rsm->addScalarResult('idValorParam','idValorParam');
            $rsm->addScalarResult('valorParam','valorParam');
            $rsm->addScalarResult('precio','precio');
            $rsm->addScalarResult('tipo','tipo');
            
            $query = $em->createNativeQuery($sql, $rsm);
            $query->setParameter(1, $id);
            $query->setParameter(2, $prod);
            $param = $query->getResult();
            
            $response = new JsonResponse();
            $response->setData(array(
                           'paramsVal' => $param
                    )); 
            
            return $response; 
        } else {    
            return new Response('0');              
        }  
    }
    
    /**
    * Ajax utilizado para buscar el precio del atributo seleccionado
    *  
    * @Route("/attributes/getPrecio", name="get_attributes_precio")
    */
    public function attributesValuesAction(Request $request)
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
            $em = $this->getDoctrine()->getManager();    
            $data = $request->request->get('request');
            $code = $request->request->get('code_promo');
            $promo = $em->getRepository('DGImpresionBundle:Promocion')->findOneBy(array('codigo' => $code));
            $porcentaje = 0;
            $total = 0;
            
            if( $promo != NULL && $code != '' ){
                $porcentaje = $promo->getPorcentaje();
            } 
            
            foreach ($data as $key => $value) {
                $rsm = new ResultSetMapping();
                $sql = "select op.costo as precio "
                        . "from opcion_producto op "
                        . "where op.id = ? ";

                $rsm->addScalarResult('precio','precio');
                $query = $em->createNativeQuery($sql, $rsm);
                $query->setParameter(1, $value);
                $param = $query->getSingleResult();
                
                $total+=$param['precio'];
            }
            
            $response = new JsonResponse();
            $response->setData(array(
                           'data'         => $data,
                           'precio'     => $total,
                           'porcentaje' => $porcentaje,
                           'flag'       => 1
                    )); 

            return $response; 
        } else {    
            return new Response('0');              
        }  
    }
    
    /**
    * Ajax utilizado para buscar el precio del atributo seleccionado
    *  
    * @Route("/attribute/getPrecio", name="get_attribute_precio")
    */
    public function attributeValuesAction(Request $request)
    {
        $isAjax = $this->get('Request')->isXMLhttpRequest();
        if($isAjax){
            $em = $this->getDoctrine()->getManager();    
            $data = $request->request->get('request');
            $total = 0;
            
            foreach ($data as $key => $value) {
                $rsm = new ResultSetMapping();
                $sql = "select op.costo as precio "
                        . "from opcion_producto op "
                        . "where op.id = ? ";

                $rsm->addScalarResult('precio','precio');

                $query = $em->createNativeQuery($sql, $rsm);
                $query->setParameter(1, $value);
                $param = $query->getSingleResult();
                
                $total+=$param['precio'];
                //var_dump($param['precio']);
            }
            
            //var_dump($total);
            
            
//            $code = $this->get('request')->request->get('code');
//            
//            $em = $this->getDoctrine()->getManager();            
//            $promo = $em->getRepository('DGImpresionBundle:Promocion')->findOneBy(array('codigo' => $code));
//            //var_dump($promo);
//            $porcentaje = 0;
//            
//            if( $promo != NULL && $code != '' ){
//                $porcentaje = $promo->getPorcentaje();
//            } 
//            
//            if($id == 0){
//                $param[0] = 0;
//                $response = new JsonResponse();
//                $response->setData(array(
//                           'flag' => 0
//                    ));    
//                
//                return $response; 
//            } else {
//            
//                $em = $this->getDoctrine()->getManager();            
//                //$cat = $em->getRepository('DGImpresionBundle:Categoria')->find($id);
//
//                $rsm = new ResultSetMapping();
//                $sql = "select op.costo as precio "
//                        . "from opcion_producto op "
//                        . "where op.id = ? ";
//
//                $rsm->addScalarResult('precio','precio');
//
//                $query = $em->createNativeQuery($sql, $rsm);
//                $query->setParameter(1, $id);
//                $param = $query->getSingleResult();
//
//               // var_dump($param);
//                
                $response = new JsonResponse();
                $response->setData(array(
                               'data'         => $data,
                               'precio'     => $total,
//                               'porcentaje' => $porcentaje,
                               'flag'       => 1
                        )); 
//
                return $response; 
//            }
            
        } else {    
            return new Response('0');              
        }  
    }
}

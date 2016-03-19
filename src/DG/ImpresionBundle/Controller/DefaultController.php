<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('DGImpresionBundle:Default:index.html.twig');
    }
    
    /**
     * @Route("/categories")
     */
    public function categoriesAction()
    {
        return $this->render('DGImpresionBundle:Default:categories.html.twig');
    }
}

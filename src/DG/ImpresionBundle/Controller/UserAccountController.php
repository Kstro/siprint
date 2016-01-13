<?php

namespace DG\ImpresionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/admin")
 */
class UserAccountController extends Controller{
    /**
     * @Route("/myaccount", name="dg_my_account")
     * 
     */
    public function MyAccountAction()
    {
        return $this->render(':useraccount:myaccount.html.twig');
    }
}

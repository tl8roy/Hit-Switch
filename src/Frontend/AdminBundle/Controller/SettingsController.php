<?php

namespace Frontend\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
* @Route("/admin")
*/
class SettingsController extends Controller
{
    /**
     * Route(
     *      path = "/settings",
     *      name = "admin_settings"
     *      )
     */
    public function profileAction()
    {
        return $this->render('FrontendAdminBundle:Secured:profile.html.twig');
    }
    
    /**
     * Route("/device/edit")
     */
    public function deviceEditAction($id)
    {

    }
    
    /**
     * Route("/message/edit")
     */
    public function messageEditAction($id)
    {

    }
    
    /**
     * Route("/action/edit")
     */
    public function actionEditAction($id)
    {

    }
}

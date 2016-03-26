<?php

namespace Frontend\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{

    public function navAction($location)
    {
        
        $cmspages = $this->getDoctrine()
                ->getRepository('FrontendCMSBundle:Cmspage')
                ->findAll();
        return $this->render('FrontendAdminBundle:Normal:nav.html.twig',array('pages' => $cmspages,'location' => $location));
    }
}

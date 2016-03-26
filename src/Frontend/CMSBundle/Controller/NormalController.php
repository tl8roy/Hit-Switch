<?php

namespace Frontend\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation\Request;

use Frontend\CMSBundle\Entity\Cmspage;

class NormalController extends Controller
{

    /**
     * @Route(
     *      path = "/edit/{slug}",
     *      name = "cms_edit",
     *      defaults     = { "slug" = "index" },
     *      methods      = { "POST" }
     *      )
     */
    public function editAction(Request $request,$slug)
    {
        
        $cmspage = $this->getDoctrine()
                ->getRepository('FrontendCMSBundle:Cmspage')
                ->findOneBy(array('name' => $slug));
        
        if (!($cmspage instanceof Cmspage)) {
            throw $this->createNotFoundException('This page does not exist');
        }
        
        if($request->get('content')){
            $cmspage->setContent($request->get('content'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($cmspage);
            $em->flush();
        } else {
            return new Response('ERROR',400);  
        }

        return new Response('OK',204);        
    }
    
    /**
     * @Route(
     *      path = "/{slug}",
     *      name = "cms_index",
     *      defaults     = { "slug" = "index" },
     *      methods      = { "GET" }
     *      )
     */
    public function indexAction(Request $request,$slug)
    {
        $cmspage = $this->getDoctrine()
                ->getRepository('FrontendCMSBundle:Cmspage')
                ->findOneBy(array('slug' => $slug));
        
        if (!($cmspage instanceof Cmspage)) {
            throw $this->createNotFoundException('This page does not exist');
        }
        
        $response = new Response();
        $response->setLastModified($cmspage->getDateModified());
        $response->setPublic();

        if ($response->isNotModified($request)) {
            return $response;
        }
        
        if($cmspage->getSlug() === 'index' ){
            $pageTemplate = 'index';
        } else {
            $pageTemplate = 'cmspage';
        }
        
        return $this->render('FrontendCMSBundle:Normal:'.$pageTemplate.'.html.twig',array('cmspage' => $cmspage));
    }
    
}

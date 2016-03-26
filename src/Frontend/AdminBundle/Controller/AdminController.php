<?php

namespace Frontend\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Backend\APIBundle\Entity\Device;
use Backend\APIBundle\Entity\Action;


/**
* @Route("/admin")
*/
class AdminController extends Controller
{
    /**
     * @Route(
     *      path = "/profile",
     *      name = "user_profile"
     *      )
     */
    public function profileAction()
    {
        $user = $this->getUser();
        
        $devices = $this->getDoctrine()
                ->getRepository('BackendAPIBundle:Device')
                ->findBy(array('user' => $user));
                
        $actions = $this->getDoctrine()
                ->getRepository('BackendAPIBundle:Action')
                ->findBy(array('user' => $user));
        
        return $this->render('FrontendAdminBundle:Secured:profile.html.twig',array('devices' => $devices, 'actions' => $actions));
    }
    
    /**
     * @Route(
     *      path = "/device/validate",
     *      name = "user_device_validate",
     *      requirements = { "id" = "\d+" },
     *      methods      = { "GET" }
     *      )
     */
    public function devicevalidateAction($id)
    {
        $device = $this->getDoctrine()
                ->getRepository('BackendAPIBundle:Device')
                ->find($id);
   
        if($device->getActive() && $device->getDateValidated() === NULL && $device->getDateLastAccess() !== NULL){
            
            $device->setDateValidated(new \DateTime);
            $em = $this->getDoctrine()->getManager();
            $em->persist($device);
            $em->flush();
        }
        
        return new RedirectResponse($this->generateUrl('user_profile'));
    }
    
    /**
     * @Route(
     *      path = "/device/edit",
     *      name = "user_device_edit",
     *      defaults     = { "id" = null },
     *      requirements = { "id" = "\d+" },
     *      methods      = { "POST" }
     *      )
     */
    public function deviceEditAction(Request $request, $id)
    {
        if($id){
            $device = $this->getDoctrine()
                ->getRepository('BackendAPIBundle:Device')
                ->find($id);
            
            if($request->get('reset_key')){
                $device->resetKey($this->container->getParameter('token_length'));
            }
            $device->setActive(($request->get('active')?true:false));
            
        } else {
            $device = new Device();
            $device->setUser($this->getUser())
              ->resetKey($this->container->getParameter('token_length'));
        }

        $device->setName($request->get('name'));
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($device);
        $em->flush();
        
        return new RedirectResponse($this->generateUrl('user_profile'));

    }
    
    /**
     * @Route(
     *      path = "/message/edit",
     *      name = "user_message_edit",
     *      defaults     = { "id" = null },
     *      requirements = { "id" = "\d+" },
     *      methods      = { "POST" }
     *      )
     */
    public function messageEditAction($id)
    {

    }
    
    /**
     * @Route(
     *      path = "/action/edit",
     *      name = "user_action_error",
     *      defaults     = { "id" = null },
     *      requirements = { "id" = "\d+" },
     *      methods      = { "POST" }
     *      )
     */
    public function actionEditAction($id)
    {

    }
    
    private function processActionEdit(Request $request, Action $action){
        
        return $action;
    }
    
}

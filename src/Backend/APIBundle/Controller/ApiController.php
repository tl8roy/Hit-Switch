<?php

namespace Backend\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\JsonResponse;

use Backend\APIBundle\Entity\Device;
use Backend\APIBundle\Entity\Message;
use Backend\APIBundle\Event\ProcessActions;

/**
 * @Route("/api")
 */
class ApiController extends Controller
{
    /**
     * @Route("/validate")
     */
    public function validateAction()
    {
        
        $token = $this->request->get('token');

        
                
        //Look for device in DB
        $device = $this->getDoctrine()
                ->getRepository('BackendAPIBundle:Device')
                ->findOneBy(array('key' => $token));
        
        if($device instanceof Device){
            //Found
            //If found look for active and valid and last access is present
            if($device->getActive() && $device->getDateValidated() !== NULL && $device->getDateLastAccess() !== NULL){
                //Yes
                $em = $this->getDoctrine()->getManager();
                
                $message_new = $device->getMessageWithCode('reset',true);
                if($message_new instanceof Message){
                    $message_new->resetToken($this->container->getParameter('token_length'),$this->container->getParameter('token_expiry'));
                } else {
                    $messageLevelResetNew = $this->getDoctrine()
                        ->getRepository('BackendAPIBundle:MessageLevel')
                        ->findOneBy(array('code' => 'reset','current' => true));
                    
                    //Create Refresh Messages
                    $message_new = new Message();
                    $message_new
                        ->setDevice($device)
                        ->resetToken($this->container->getParameter('token_length'),$this->container->getParameter('token_expiry'))
                        ->setMessagesLevel($messageLevelResetNew);
                    
                }
                $em->persist($message_new);
                
                $message_new = $device->getMessageWithCode('reset',false);
                if($message_old instanceof Message){
                    $message_old->resetToken($this->container->getParameter('token_length'),$this->container->getParameter('token_expiry'));
                } else {
                    $messageLevelResetOld = $this->getDoctrine()
                        ->getRepository('BackendAPIBundle:MessageLevel')
                        ->findOneBy(array('code' => 'reset','current' => false));
                    
                    //Create Refresh Messages
                    $message_old = new Message();
                    $message_old
                        ->setDevice($device)
                        ->resetToken($this->container->getParameter('token_length'),$this->container->getParameter('token_expiry'))
                        ->setMessagesLevel($messageLevelResetOld);
                }
                $em->persist($message_old);

                $em->flush();
                
                //Send new refresh token
                return new JsonResponse(array('refresh' => $message_new->getToken()));
            } elseif($device->getActive()) {              
                //No
                //If active and not valid and last access is not present
                if($device->getDateLastAccess() !== NULL){
                    //Yes
                    //Mark Last access
                    $device->setDateLastAccess(new \DateTime());
                    
                    //Send Validation Email
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Device Validation')
                        ->setFrom('tl8@tl8.co')
                        ->setTo($device->getUser()->getEmail())
                        ->setBody(
                            $this->renderView(
                                'FrontendAdminBundle:Emails/registration.html.twig',
                                array('device' => $device)
                            ),
                            'text/html'
                        );
                    $this->get('mailer')->send($message);
                    
                    
                    //Send 201
                    return new Response('Waiting',201);
                } else {
                    //No
                    //Send 202 (Waiting)
                    return new Response('Waiting',202);  
                }
            } else {
                //Not active, do nothing
            }
        } else {            
            //Not Found
            return new Response('No Device Found',404);  
            //Return 404
        }
        
    }
    
    /**
     * @Route("/message")
     */
    public function messageAction()
    {
        $token = $this->request->get('token');
        
        //Look for message in DB
        $message = $this->getDoctrine()
                ->getRepository('BackendAPIBundle:Message')
                ->findOneBy(array('token' => $token));
        //TokenExpriey before now
        
        //Found and Device Active and Device Valid
        if($message instanceof Message && $device->getActive() && $device->getDateValidated() !== NULL && $device->getDateLastAccess() !== NULL){
            
            //If Token Refresh
            if($message->getMessagesLevel()->getCode() == 'reset'){
                //Yes
                $em = $this->getDoctrine()->getManager();
                
                //Update the last access
                $message->getDevice()->setDateLastAccess(new \DateTime());
                $message->setDateLastAccess(new \DateTime());
                $em->persist($message->getDevice());
                $em->persist($message);
                $em->flush();
                
                $messageLevels = $this->getDoctrine()
                        ->getRepository('BackendAPIBundle:MessageLevel')
                        ->findBy(array('current' => true));
                
                $tokens = array();
                
                foreach($messageLevels as $messageLevel){
                    //Get Current Messages
                    $messages = $message->getDevice()->getMessageWithCode($messageLevel->getCode(),true);
                    
                    if(count($messages) === 1){
                        $messageToReset = $messages[0]; //Should only be one

                        $messageBackups = $message->getDevice()->getMessageWithCode($messageLevel->getCode(),false);
                        //Copy to Backup Messages (Create if they don't Exist)
                        if(count($messageBackups) === 1){
                            $messageBackup = $messageBackups[0];
                        } elseif (count($messageBackups) === 0){
                            
                            $messageLevelBackup = $this->getDoctrine()
                                ->getRepository('BackendAPIBundle:MessageLevel')
                                ->findOneBy(array('code' => $messageLevel->getCode(),'current' => false));
                            
                            $messageBackup = new Message();
                            $messageBackup
                                ->setDevice($device)
                                ->resetToken($this->container->getParameter('token_length'),$this->container->getParameter('token_expiry'))
                                ->setMessagesLevel($messageLevelBackup);
                        }
                        
                        $messageBackup->setToken($messageToReset->getToken());
                        $messageBackup->setTokenExpiry($messageToReset->getTokenExpiry());

                        $messageToReset->resetToken($this->container->getParameter('token_length'),$this->container->getParameter('token_expiry'));

                        $em->persist($messageBackup);
                        $em->persist($messageToReset);
                        
                        $tokens[] = $messageBackup->serialize();
                        $tokens[] = $messageToReset->serialize();
                    }
                }

                $em->flush();
                
                
                //Refresh Token
                return new JsonResponse(array('refresh' => $tokens));
            } else {
                //No
                //Get and Do All Actions
                $event = new ProcessActions($message);
                $this->get('event_dispatcher')->dispatch('backendapi.event.process_actions', $event);
                
                $message->getDevice()->setDateLastAccess(new \DateTime());
                $message->setDateLastAccess(new \DateTime());
                $message->setTokenExpiry(new \DateTime()); //Token is now invalid forcing reset

                $em = $this->getDoctrine()->getManager();
                $em->persist($message->getDevice());
                $em->persist($message);
                $em->flush();
                
                //Return 204
                return new Response('OK',204); 
            }
        } elseif($message instanceof Message) {
        //Not Device Active or Device Valid
            //Return 418
            return new Response('Device Inactive',418); 
        } else {
        //Not Found
            //Return 404
            return new Response('No Device Found',404); 
        }

    }
}

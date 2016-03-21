<?php

namespace Backend\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\JsonResponse;

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
        
        //Found and Under Ratelimit
        //If found look for active and valid
            //Yes
            //Create Refresh Messages
            //Send new refresh token
            return new JsonResponse(array('refresh' => $token));
        
            //No
            //If not active
                //Yes
                //Mark Active
                //Send Validation Email
                //Send 201
                
                //No
                //Send 202 (Waiting)
           
        //Over Ratelimit
            //Return 429 
            
        //Not Found
            //Return 404
        
        
    }
    
    /**
     * @Route("/message")
     */
    public function messageAction()
    {
        $token = $this->request->get('token');
        
        //Look for message in DB
        
        //Found and Under Ratelimit and Device Active and Device Valid
            //If Token Refresh
                //Yes
                //Get Current Messages
                //Copy to Backup Messages (Create if they don't Exist)
                //Refresh Token
                return new JsonResponse(array('refresh' => $token));
        
                //No
                //Get and Do All Actions
                //Return 204
           
        //Over Ratelimit
            //Return 429 
            
        //Not Device Active or Device Valid
            //Return 418
            
        //Not Found
            //Return 404

    }
}

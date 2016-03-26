<?php

namespace Backend\APIBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Backend\APIBundle\Event\ProcessActions;

class ProcessActionsListener implements EventSubscriberInterface
{
    
    protected $em;
    
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            'backendapi.event.process_actions' => 'handler',
        );
    }

    public function handler(ProcessActions $event)
    {
        // $event->getName();
        // do what you want with the event
    }
}



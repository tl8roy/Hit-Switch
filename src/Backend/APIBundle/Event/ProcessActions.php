<?php

namespace Backend\APIBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class ProcessActions extends Event
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }
}

<?php

namespace Backend\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Log
 *
 * @ORM\Table(name="log")
 * @ORM\Entity(repositoryClass="Backend\APIBundle\Repository\MessageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Log
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_triggered", type="datetime")
     */
    private $dateTriggered;

    
    /**
     * @var Message
     *
     * @ORM\ManyToOne(targetEntity="Message")
     */
    private $message;

    /**
     * @var int
     *
     * @ORM\Column(name="parameters", type="integer")
     */
    private $creditsUsed;
    

    /**
    * @ORM\PrePersist
    */
    public function setTriggered()
    {
        $this->dateTriggered = new \DateTime();      
    }
   
    public function __construct(Message $message,$creditsUsed) {
        $this->message = $message;
        $this->creditsUsed = $creditsUsed;
    }
}

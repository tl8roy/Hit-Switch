<?php

namespace Backend\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Log
 *
 * @ORM\Table(name="message_log")
 * @ORM\Entity(repositoryClass="Backend\APIBundle\Repository\MessageLogRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class MessageLog
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

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateTriggered
     *
     * @param \DateTime $dateTriggered
     *
     * @return MessageLog
     */
    public function setDateTriggered($dateTriggered)
    {
        $this->dateTriggered = $dateTriggered;

        return $this;
    }

    /**
     * Get dateTriggered
     *
     * @return \DateTime
     */
    public function getDateTriggered()
    {
        return $this->dateTriggered;
    }

    /**
     * Set creditsUsed
     *
     * @param integer $creditsUsed
     *
     * @return MessageLog
     */
    public function setCreditsUsed($creditsUsed)
    {
        $this->creditsUsed = $creditsUsed;

        return $this;
    }

    /**
     * Get creditsUsed
     *
     * @return integer
     */
    public function getCreditsUsed()
    {
        return $this->creditsUsed;
    }

    /**
     * Set message
     *
     * @param \Backend\APIBundle\Entity\Message $message
     *
     * @return MessageLog
     */
    public function setMessage(\Backend\APIBundle\Entity\Message $message = null)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return \Backend\APIBundle\Entity\Message
     */
    public function getMessage()
    {
        return $this->message;
    }
}

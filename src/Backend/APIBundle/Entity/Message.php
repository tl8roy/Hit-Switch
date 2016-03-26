<?php

namespace Backend\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="Backend\APIBundle\Repository\MessageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Message
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
     * @ORM\Column(name="date_modified", type="datetime")
     */
    private $dateModified;
    
    /**
     * @ORM\ManyToOne(targetEntity="Device",inversedBy="messages")
     */
    private $device;
    
    /**
     * @ORM\ManyToOne(targetEntity="MessageLevel")
     */
    private $messagesLevel;
    
    /**
     * @ORM\ManyToMany(targetEntity="Action")
     */
    private $actions;
    
    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, unique=true)
     */
    private $token;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="token_expiry", type="datetime")
     */
    private $tokenExpiry;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_last_access", type="datetime",nullable=true)
     */
    private $dateLastAccess;

    /**
    * @ORM\PreUpdate
    * @ORM\PrePersist
    */
    public function setModified()
    {
        $this->dateModified = new \DateTime();      
    }
    
    public function resetToken($length,$hours){
        
        $this->tokenExpiry = new \DateTime();
        $this->tokenExpiry->add(new \DateInterval('PT'.$hours.'H'));
        
        $this->token = str_replace(array('+','=','/'),'',base64_encode(random_bytes($length)));
        
        return $this;
    }
    
    public function serialize(){
        return array($this->messagesLevel->getCode() => $this->token); 
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
     * Set dateModified
     *
     * @param \DateTime $dateModified
     * @return Message
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * Get dateModified
     *
     * @return \DateTime 
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->actions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Message
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set tokenExpiry
     *
     * @param \DateTime $tokenExpiry
     *
     * @return Message
     */
    public function setTokenExpiry($tokenExpiry)
    {
        $this->tokenExpiry = $tokenExpiry;

        return $this;
    }

    /**
     * Get tokenExpiry
     *
     * @return \DateTime
     */
    public function getTokenExpiry()
    {
        return $this->tokenExpiry;
    }

    /**
     * Set dateLastAccess
     *
     * @param \DateTime $dateLastAccess
     *
     * @return Message
     */
    public function setDateLastAccess($dateLastAccess)
    {
        $this->dateLastAccess = $dateLastAccess;

        return $this;
    }

    /**
     * Get dateLastAccess
     *
     * @return \DateTime
     */
    public function getDateLastAccess()
    {
        return $this->dateLastAccess;
    }

    /**
     * Set device
     *
     * @param \Backend\APIBundle\Entity\Device $device
     *
     * @return Message
     */
    public function setDevice(\Backend\APIBundle\Entity\Device $device = null)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * Get device
     *
     * @return \Backend\APIBundle\Entity\Device
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Set messagesLevel
     *
     * @param \Backend\APIBundle\Entity\MessageLevel $messagesLevel
     *
     * @return Message
     */
    public function setMessagesLevel(\Backend\APIBundle\Entity\MessageLevel $messagesLevel = null)
    {
        $this->messagesLevel = $messagesLevel;

        return $this;
    }

    /**
     * Get messagesLevel
     *
     * @return \Backend\APIBundle\Entity\MessageLevel
     */
    public function getMessagesLevel()
    {
        return $this->messagesLevel;
    }

    /**
     * Add action
     *
     * @param \Backend\APIBundle\Entity\Action $action
     *
     * @return Message
     */
    public function addAction(\Backend\APIBundle\Entity\Action $action)
    {
        $this->actions[] = $action;

        return $this;
    }

    /**
     * Remove action
     *
     * @param \Backend\APIBundle\Entity\Action $action
     */
    public function removeAction(\Backend\APIBundle\Entity\Action $action)
    {
        $this->actions->removeElement($action);
    }

    /**
     * Get actions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActions()
    {
        return $this->actions;
    }
}

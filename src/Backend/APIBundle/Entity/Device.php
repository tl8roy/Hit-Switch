<?php

namespace Backend\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Device
 *
 * @ORM\Table(name="device")
 * @ORM\Entity(repositoryClass="Backend\APIBundle\Repository\DeviceRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Device
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime")
     */
    private $dateModified;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = true;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_validated", type="datetime",nullable=true)
     */
    private $dateValidated;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_last_access", type="datetime",nullable=true)
     */
    private $dateLastAccess;
    
    /**
     * @var string
     *
     * @ORM\Column(name="key", type="string", length=255, unique=true)
     */
    private $key;
    
    /**
     * @ORM\ManyToOne(targetEntity="Frontend\AdminBundle\Entity\User",inversedBy="devices")
     */
    private $user;
    
    /**
     * @ORM\OneToMany(targetEntity="Message",mappedBy="device")
     */
    private $messages;

    /**
     * Get message
     *
     * @return message 
     */
    public function getMessageWithCode($code,$current = true)
    {
    }
    
    public function resetKey($length){
        
        $this->key = str_replace(array('+','=','/'),'',base64_encode(random_bytes($length)));
        
        return $this;
    }
    
    public function getVisibleActions(){
        $actions = array();
        foreach ($this->messages as $message){
            if($message->getMessageLevel()->getVisible()){
                $actions = array_merge($message->getActions());
            }
        }
        return $actions;
    }
    
    /**
    * @ORM\PreUpdate
    * @ORM\PrePersist
    */
    public function setModified()
    {
        $this->dateModified = new \DateTime();      
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
     * @return Device
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
     * Set name
     *
     * @param string $name
     * @return Device
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

   
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Device
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set dateValidated
     *
     * @param \DateTime $dateValidated
     *
     * @return Device
     */
    public function setDateValidated($dateValidated)
    {
        $this->dateValidated = $dateValidated;

        return $this;
    }

    /**
     * Get dateValidated
     *
     * @return \DateTime
     */
    public function getDateValidated()
    {
        return $this->dateValidated;
    }

    /**
     * Set dateLastAccess
     *
     * @param \DateTime $dateLastAccess
     *
     * @return Device
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
     * Set key
     *
     * @param string $key
     *
     * @return Device
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set user
     *
     * @param \Frontend\AdminBundle\Entity\User $user
     *
     * @return Device
     */
    public function setUser(\Frontend\AdminBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Frontend\AdminBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add message
     *
     * @param \Backend\APIBundle\Entity\Message $message
     *
     * @return Device
     */
    public function addMessage(\Backend\APIBundle\Entity\Message $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param \Backend\APIBundle\Entity\Message $message
     */
    public function removeMessage(\Backend\APIBundle\Entity\Message $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }
}

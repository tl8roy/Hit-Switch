<?php

namespace Backend\APIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Action
 *
 * @ORM\Table(name="hs_action")
 * @ORM\Entity(repositoryClass="Backend\APIBundle\Repository\ActionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Action
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
     * @ORM\ManyToOne(targetEntity="Frontend\AdminBundle\Entity\User",inversedBy="actions")
     */
    private $user;
    
    /**
     * @var string
     *
     * @ORM\ManyToMany(targetEntity="Message")
     */
    private $messages;

    /**
     * @var Object
     *
     * @ORM\Column(name="parameters", type="json_array",nullable=true)
     */
    private $parameters;
    

    /**
    * @ORM\PreUpdate
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
     * @return Cmspage
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
     * @return Action
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
     * @return Action
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
     * Set parameters
     *
     * @param array $parameters
     *
     * @return Action
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set user
     *
     * @param \Frontend\AdminBundle\Entity\User $user
     *
     * @return Action
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
     * @return Action
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

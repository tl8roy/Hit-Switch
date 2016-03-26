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
     * @ORM\Column(name="date_validated", type="datetime")
     */
    private $dateValidated;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_last_access", type="datetime")
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

   
}

<?php
namespace Frontend\AdminBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="action")
 * @ORM\Entity(repositoryClass="Frontend\AdminBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, EquatableInterface
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
     * @ORM\Column(name="name", type="string", length=255,nullable="true")
     */
    private $name;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime")
     */
    private $dateModified;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;
    
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=64,nullable="true")
     */
    private $phone;
    
    /**
     * @ORM\OneToMany(targetEntity="Device",mappedBy="user")
     */
    private $devices;
    
    /**
     * @ORM\ManyToMany(targetEntity="Action")
     */
    private $actions;
    
        
    private $jwt;
    private $roles;
    
    public function __construct($jwt, array $roles)
    {
        $this->jwt = $jwt;
        $this->roles = $roles;
    }
    public function getRoles()
    {
        return $this->roles;
    }
    public function getPassword()
    {
        return null;
    }
    public function getSalt()
    {
        return null;
    }
    public function getUsername()
    {
        return $this->jwt["email"];
    }
    public function eraseCredentials()
    {
    }
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }
        if ($this->getUsername() !== $user->getUsername()) {
            return false;
        }
        return true;
    }
}
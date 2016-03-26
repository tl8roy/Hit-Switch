<?php
namespace Frontend\AdminBundle\Security;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

use Frontend\AdminBundle\Entity\User;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RequestStack;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
/***
 * Class Provider
 * @package CodeMe\TheBundle\Provider
 *
 *
 */
class A0UserProvider extends OAuthUserProvider
{
    /***
     * @var Session
     */
    protected $session;
    /**
     * @var Array
     */
    protected $admin_list;
    /**
     * @var Doctrine
     */
    protected $doctrine;
    /***
     * @param Session $session
     * @param Doctrine $doctrine
     * @param RequestStack $requestStack
     */
    public function __construct(Session $session, Doctrine $doctrine, $admin_list) {
        $this->session = $session;
        $this->doctrine = $doctrine;
        $this->admin_list   = $admin_list;
    }
    private function getUserById($id) {
        return $this->doctrine
            ->getRepository('Frontend\AdminBundle\Entity\User')
            ->findOneById($id);
    }
    /***
     * @param string $id
     * @return User
     */
    public function loadUserByUsername($id)
    {
        $user = $this->getUserById($id);

        $user->setRoles(in_array($user->getEmail(), $this->admin_list));
        
        return $user;
        //return new User($id, $user, $this->adminChecker->check($user));
    }
    /***
     * @param UserResponseInterface $response
     * @return User
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {

        //check to see if the user is logged in
        $isLoggedInAlready = $this->session->has('user');
        
        if($isLoggedInAlready){
            $isLoggedInAlreadyId = $this->session->get('user')['id'];
            return $this->loadUserByUsername($isLoggedInAlreadyId);
        }
        
        $nickname = $response->getNickname();
        $realName = $response->getRealName();
        $email = $response->getEmail();

        //$user = null;

        $user = $this->doctrine
            ->getRepository('Frontend\AdminBundle\Entity\User')
            ->findOneBy($email);

  
        if ($user == null) {
            $user = new User();
            //change these only the user hasn't been registered before.
            $user->setNickname($nickname);
            $user->setEmail($email);
            $user->setRealname($realName);
            
            //save all changes
            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();
        }

        $id = $user->getId();

        //set data in session. upon logging out we just erase the whole array.
        $sessionData = array();
        $sessionData['id'] = $id;

        $this->session->set('user', $sessionData);
        return $this->loadUserByUsername($user->getId());
    }
    /***
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === 'Frontend\\AdminBundle\\Entity\\User';
    }
}
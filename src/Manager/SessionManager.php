<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 03/08/17
 * Time: 17:33
 */

namespace Manager;

use Framework\Container\Doctrine;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionManager
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var User
     */
    private $user = null;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * SessionManager constructor.
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack, Doctrine $doctrine)
    {
        if ($requestStack->getCurrentRequest()->getSession() === null) {
            $requestStack->getCurrentRequest()->setSession(new Session());
        }
        $this->session = $requestStack->getCurrentRequest()->getSession();
        $this->entityManager = $doctrine->getManager();
    }

    public function set($formData)
    {
        $user = $this->check($formData["email"]);
        if($user === null){
            throw new \Exception('Utilisateur inexistant');
        }
        if($user->getPassword() !=  sha1($formData["password"])){
            throw new \Exception('Mot de passe erroné');
        }
        $this->session->set("AUTH",$user->getId());
    }

    public function isAuthenticated()
    {
        return $this->session->has("AUTH");
    }

    public function getUser()
    {
        if($this->isAuthenticated()){
            if($this->user === null){
                $this->user = $this->provider($this->session->get("AUTH"));
            }
            return $this->user;
        }else{
            return null;
        }
    }

    public function clear()
    {
        $this->session->remove("AUTH");
    }

    public function check($email)
    {
        return $this->entityManager->getRepository("Entity\User")->findOneByEmail($email);
    }

    public function provider($id)
    {
        return $this->entityManager->getRepository("Entity\User")->find($id);
    }

    public function isGranted(...$roles)
    {
        return count(array_diff($roles,$this->getUser()->getRoles())) == 0;
    }
}
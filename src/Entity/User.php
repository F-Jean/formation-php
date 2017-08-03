<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 03/08/17
 * Time: 17:07
 */

namespace Entity;

/**
 * Class User
 * @package Entity
 *
 * @Entity
 * @Table(name="user")
 * @HasLifecycleCallbacks
 */
class User
{
    /**
     * @var integer
     *
     * @Id
     * @GeneratedValue
     * @Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var array
     *
     * @Column(name="roles", type="array")
     */
    private $roles;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @PrePersist()
     */
    public function prePersist()
    {
        $this->roles = ["ROLE_USER"];
    }
}
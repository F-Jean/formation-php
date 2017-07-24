<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 24/07/17
 * Time: 19:42
 */

namespace Entity;

/**
 * Class Category
 * @package Entity
 *
 * @Entity
 * @Table(name="category")
 */
class Category
{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="name", type="string")
     */
    private $name;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 24/07/17
 * Time: 19:22
 */

namespace Entity;

/**
 * Class Product
 * @package Entity
 *
 * @Entity
 * @Table(name="product")
 */
class Product
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
     * @var string
     *
     * @Column(name="description", type="text")
     */
    private $description;

    /**
     * @var float
     *
     * @Column(name="price_et", type="decimal", precision=8, scale=2)
     */
    private $priceET;

    /**
     * @var float
     *
     * @Column(name="vat", type="decimal", precision=8, scale=2)
     */
    private $vat;

    /**
     * @var string
     *
     * @Column(name="image", type="string", nullable=true)
     */
    private $image;

    /**
     * @var Category
     *
     * @ManyToOne(targetEntity="Category")
     * @JoinColumn(name="category_id")
     */
    private $category;

    /**
     * @var Brand
     *
     * @ManyToOne(targetEntity="Brand")
     * @JoinColumn(name="brand_id")
     */
    private $brand;

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

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getPriceET()
    {
        return $this->priceET;
    }

    /**
     * @param float $priceET
     */
    public function setPriceET($priceET)
    {
        $this->priceET = $priceET;
    }

    /**
     * @return float
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * @param float $vat
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return float
     */
    public function getPriceIT()
    {
        return $this->priceET*(1+$this->vat);
    }
}
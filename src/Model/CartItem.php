<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 29/07/17
 * Time: 12:25
 */

namespace Model;


use Entity\Product;

/**
 * Class CartItem
 * @package Model
 */
class CartItem
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var integer
     */
    private $quantity;

    /**
     * CartItem constructor.
     * @param Product $product
     * @param integer $quantity
     */
    public function __construct(Product $product, $quantity)
    {
        $this->quantity = $quantity;
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     *
     */
    public function increaseQuantity()
    {
        $this->quantity++;
    }

    /**
     *
     */
    public function decreaseQuantity()
    {
        $this->quantity--;
    }
}
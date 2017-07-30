<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 30/07/17
 * Time: 15:34
 */

namespace Entity;

/**
 * Class OrderLine
 * @package Entity
 *
 * @Entity
 * @Table(name="shop_order_line")
 */
class OrderLine
{
    /**
     * @var integer
     * @Id
     * @GeneratedValue
     * @Column(name="id",type="integer")
     */
    private $id;

    /**
     * @var Order
     *
     * @ManyToOne(targetEntity="Order", inversedBy="lines")
     * @JoinColumn(name="order_id")
     */
    private $order;

    /**
     * @var Product
     *
     * @ManyToOne(targetEntity="Product")
     * @JoinColumn(name="product_id")
     */
    private $product;

    /**
     * @var float
     *
     * @Column(name="price_et", type="decimal", precision=10, scale=2)
     */
    private $priceET;

    /**
     * @var float
     *
     * @Column(name="vat", type="decimal", precision=10, scale=2)
     */
    private $vat;

    /**
     * @var integer
     *
     * @Column(name="quantity", type="integer")
     */
    private $quantity;

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
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
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


}
<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 29/07/17
 * Time: 12:28
 */

namespace Manager;

use Doctrine\ORM\EntityManager;
use Framework\Container\Doctrine;
use Model\CartItem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class CartManager
 * @package Manager
 */
class CartManager
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var EntityManager
     */
    private $doctrine;

    /**
     * @var array
     */
    private $products = [];

    /**
     * CartManager constructor.
     * @param RequestStack $requestStack
     * @param Doctrine $doctrine
     */
    public function __construct(RequestStack $requestStack, Doctrine $doctrine)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->doctrine = $doctrine->getManager();
        $this->initCart();
    }

    /**
     * @return array
     */
    public function getCart()
    {
        return $this->products;
    }

    /**
     * Initialize products
     */
    private function initCart()
    {
        if($this->request->getSession() === null){
            $this->request->setSession(new Session());
        }
        $cart = $this->request->getSession()->get("cart");
        if(!empty($cart)){
            foreach($cart as $product_id=>$quantity){
                $this->products[$product_id] = new CartItem(
                    $this->doctrine->getRepository("Entity\Product")->find($product_id),
                    $quantity
                );
            }
        }
    }

    public function emptyCart()
    {
        $this->request->getSession()->remove("cart");
        $this->initCart();
    }

    private function reloadSession()
    {
        $this->request->getSession()->set("cart", array_map(function(CartItem $cartItem){
            return $cartItem->getQuantity();
        },$this->products));
    }

    public function addCart($id)
    {
        $product = $this->doctrine->getRepository("Entity\Product")->find($id);
        if(isset($this->products[$product->getId()])){
            $this->products[$product->getId()]->increaseQuantity();
        }else{
            $this->products[$product->getId()]= new CartItem(
                $product,
                1
            );
        }
        $this->reloadSession();
    }

    public function deleteCart($id)
    {
        if(isset($this->products[$id]) && $this->products[$id]->getQuantity() > 1){
            $this->products[$id]->decreaseQuantity();
        }else{
            unset($this->products[$id]);
        }
        $this->reloadSession();
    }

    public function getTotalET()
    {
        return array_reduce($this->products,function($total,CartItem $cartItem){
            $total += $cartItem->getProduct()->getPriceET()*$cartItem->getQuantity();
            return $total;
        });
    }

    public function getTotalVAT()
    {
        return array_reduce($this->products,function($total,CartItem $cartItem){
            $total += $cartItem->getProduct()->getPriceET()*$cartItem->getProduct()->getVat()*$cartItem->getQuantity();
            return $total;
        });
    }

    public function getTotalIT()
    {
        return array_reduce($this->products,function($total,CartItem $cartItem){
            $total += $cartItem->getProduct()->getPriceIT()*$cartItem->getQuantity();
            return $total;
        });
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/07/17
 * Time: 15:42
 */

namespace Controller;

use Entity\Order;
use Entity\OrderLine;
use Framework\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    public function indexAction($category = null)
    {
        if($category === null){
            $products = $this->getDoctrine()->getRepository("Entity\Product")->findAll();
        }else{
            $category = $this->getDoctrine()->getRepository("Entity\Category")->find($category);
            $products = $this->getDoctrine()->getRepository("Entity\Product")->findByCategory($category);
        }
        return $this->render("default/index.html.twig", ['products' => $products]);
    }

    public function cartAction()
    {
        return $this->render("default/cart.html.twig", [
                'products' => $this->get("cart_manager")->getCart(),
                "totalET"=>$this->get("cart_manager")->getTotalET(),
                "totalVAT"=>$this->get("cart_manager")->getTotalVAT(),
                "totalIT"=>$this->get("cart_manager")->getTotalIT()
            ]
        );
    }

    public function addCartAction($id)
    {
        $this->get("cart_manager")->addCart($id);
        header("location: http://formation-php.dev/cart");
        die;
    }

    public function deleteCartAction($id)
    {
        $this->get("cart_manager")->deleteCart($id);
        header("location: http://formation-php.dev/cart");
        die;
    }

    public function orderAction(Request $request)
    {
        $cart = $this->get("cart_manager")->getCart();
        if(count($cart) == 0){
            header("location: http://formation-php.dev/cart");
            die;
        }
        if($request->getMethod()=="POST"){
            $order = new Order();
            $order->setEmail($request->request->get("email"));
            $order->setLastName($request->request->get("last_name"));
            $order->setFirstname($request->request->get("first_name"));
            $order->setAddress($request->request->get("address"));
            $order->setZip($request->request->get("zip"));
            $order->setCity($request->request->get("city"));
            foreach($cart as $cartItem)
            {
                $line = new OrderLine();
                $line->setProduct($cartItem->getProduct());
                $line->setQuantity($cartItem->getQuantity());
                $line->setPriceET($cartItem->getProduct()->getPriceET());
                $line->setVat($cartItem->getProduct()->getVat());
                $order->addLine($line);
            }

            $this->getDoctrine()->persist($order);
            $this->getDoctrine()->flush();
            $this->get("cart_manager")->emptyCart();
            header("location: http://formation-php.dev/order/list");
            die;
        }
        return $this->render("default/order.html.twig", [
                'products' => $cart,
                "totalET"=>$this->get("cart_manager")->getTotalET(),
                "totalVAT"=>$this->get("cart_manager")->getTotalVAT(),
                "totalIT"=>$this->get("cart_manager")->getTotalIT()
            ]
        );
    }

    public function orderListAction()
    {
        $orders = $this->getDoctrine()->getRepository("Entity\Order")->findAll();
        return $this->render("default/orders.html.twig", ["orders"=>$orders]);
    }

    public function sidebarAction()
    {
        $categories = $this->getDoctrine()->getRepository("Entity\Category")->findAll();
        return $this->render("default/sidebar.html.twig", ["categories" => $categories]);
    }
}
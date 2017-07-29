<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/07/17
 * Time: 15:42
 */

namespace Controller;

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
                'products' => $this->getCartManager()->getCart(),
                "totalET"=>$this->getCartManager()->getTotalET(),
                "totalVAT"=>$this->getCartManager()->getTotalVAT(),
                "totalIT"=>$this->getCartManager()->getTotalIT()
            ]
        );
    }

    public function addCartAction($id)
    {
        $this->getCartManager()->addCart($id);
        header("location: http://formation-php.dev/cart");
        die;
    }

    public function deleteCartAction($id)
    {
        $this->getCartManager()->deleteCart($id);
        header("location: http://formation-php.dev/cart");
        die;
    }

    public function sidebarAction()
    {
        $categories = $this->getDoctrine()->getRepository("Entity\Category")->findAll();
        return $this->render("default/sidebar.html.twig", ["categories" => $categories]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/07/17
 * Time: 15:42
 */

namespace Controller;

use Entity\Product;
use Framework\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    public function listAction()
    {
        $products = $this->getDoctrine()->getRepository("Entity\Product")->findAll();
        return $this->render("product/list.html.twig", ["products"=>$products]);
    }

    public function addAction(Request $request)
    {
        $brands = $this->getDoctrine()->getRepository("Entity\Brand")->findAll();
        $categories = $this->getDoctrine()->getRepository("Entity\Category")->findAll();
        if($request->getMethod()=="POST"){
            $product = new Product();
            $product->setName($request->request->get("name"));
            $product->setDescription($request->request->get("description"));
            $product->setPriceET($request->request->get("price_et"));
            $product->setVat($request->request->get("vat"));
            $product->setImage("");
            $brand = $this->getDoctrine()->getRepository("Entity\Brand")->find($request->request->get("brand_id"));
            $product->setBrand($brand);
            $category = $this->getDoctrine()->getRepository("Entity\Category")->find($request->request->get("category_id"));
            $product->setCategory($category);
            $this->getDoctrine()->persist($product);
            $this->getDoctrine()->flush();
            header("location: http://formation-php.dev/product/list");
            die;
        }
        return $this->render("product/add.html.twig",["brands"=>$brands,"categories"=>$categories]);
    }

    public function updateAction(Request $request, $id)
    {
        $brands = $this->getDoctrine()->getRepository("Entity\Brand")->findAll();
        $categories = $this->getDoctrine()->getRepository("Entity\Category")->findAll();
        $product = $this->getDoctrine()->getRepository("Entity\Product")->find($id);
        if($request->getMethod()=="POST"){
            $product->setName($request->request->get("name"));
            $product->setDescription($request->request->get("description"));
            $product->setPriceET($request->request->get("price_et"));
            $product->setVat($request->request->get("vat"));
            $brand = $this->getDoctrine()->getRepository("Entity\Brand")->find($request->request->get("brand_id"));
            $product->setBrand($brand);
            $category = $this->getDoctrine()->getRepository("Entity\Category")->find($request->request->get("category_id"));
            $product->setCategory($category);
            $this->getDoctrine()->flush();
            header("location: http://formation-php.dev/product/list");
            die;
        }
        return $this->render("product/update.html.twig", ["product"=>$product,"brands"=>$brands,"categories"=>$categories]);
    }

    public function deleteAction($id)
    {
        $product = $this->getDoctrine()->getRepository("Entity\Product")->find($id);
        $this->getDoctrine()->remove($product);
        $this->getDoctrine()->flush();
        header("location: http://formation-php.dev/product/list");
        die;
    }
}
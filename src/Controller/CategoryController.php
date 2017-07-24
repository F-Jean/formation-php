<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/07/17
 * Time: 15:42
 */

namespace Controller;

use Entity\Category;
use Framework\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class CategoryController extends Controller
{
    public function listAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository("Entity\Category")->findAll();
        return $this->render("category_list.html.twig", ["categories"=>$categories]);
    }

    public function addAction(Request $request)
    {
        if($request->getMethod()=="POST"){
            $category = new Category();
            $category->setName($request->request->get("name"));
            $this->getDoctrine()->persist($category);
            $this->getDoctrine()->flush();
            header("location: http://formation-php.dev/category/list");
            die;
        }
        return $this->render("category_add.html.twig");
    }

    public function updateAction(Request $request, $id)
    {
        $category = $this->getDoctrine()->getRepository("Entity\Category")->find($id);
        if($request->getMethod()=="POST"){
            $category->setName($request->request->get("name"));
            $this->getDoctrine()->flush();
            header("location: http://formation-php.dev/category/list");
            die;
        }
        return $this->render("category_update.html.twig", ["category"=>$category]);
    }

    public function deleteAction($id)
    {
        $category = $this->getDoctrine()->getRepository("Entity\Category")->find($id);
        $this->getDoctrine()->remove($category);
        $this->getDoctrine()->flush();
        header("location: http://formation-php.dev/category/list");
        die;
    }
}
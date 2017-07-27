<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/07/17
 * Time: 15:42
 */

namespace Controller;

use Entity\Brand;
use Framework\Controller;
use Symfony\Component\HttpFoundation\Request;

class BrandController extends Controller
{
    public function listAction(Request $request)
    {
        $brands = $this->getDoctrine()->getRepository("Entity\Brand")->findAll();
        return $this->render("brand/list.html.twig", ["brands"=>$brands]);
    }

    public function addAction(Request $request)
    {
        if($request->getMethod()=="POST"){
            $brand = new Brand();
            $brand->setName($request->request->get("name"));
            $this->getDoctrine()->persist($brand);
            $this->getDoctrine()->flush();
            header("location: http://formation-php.dev/brand/list");
            die;
        }
        return $this->render("brand/add.html.twig");
    }

    public function updateAction(Request $request, $id)
    {
        $brand = $this->getDoctrine()->getRepository("Entity\Brand")->find($id);
        if($request->getMethod()=="POST"){
            $brand->setName($request->request->get("name"));
            $this->getDoctrine()->flush();
            header("location: http://formation-php.dev/brand/list");
            die;
        }
        return $this->render("brand/update.html.twig", ["brand"=>$brand]);
    }

    public function deleteAction($id)
    {
        $brand = $this->getDoctrine()->getRepository("Entity\Brand")->find($id);
        $this->getDoctrine()->remove($brand);
        $this->getDoctrine()->flush();
        header("location: http://formation-php.dev/brand/list");
        die;
    }
}
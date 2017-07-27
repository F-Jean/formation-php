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

class DefaultController extends Controller
{
    public function indexAction()
    {
        $products = $this->getDoctrine()->getRepository("Entity\Product")->findAll();
        return $this->render("default/index.html.twig", ['products' => $products]);
    }
}
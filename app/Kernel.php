<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/07/17
 * Time: 15:11
 */

namespace Framework;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class Kernel
 * @package Framework
 */
class Kernel
{
    /**
     *
     */
    public static function run()
    {
        try {
            $request = Request::createFromGlobals();
            $requestStack = new RequestStack();
            $routes = new RouteCollection();
            $routes->add("cart", new Route("/cart", [
                "_controller" => "Controller\DefaultController::cartAction"
            ]));
            $routes->add("cart_add", new Route("/cart/add/{id}", [
                "_controller" => "Controller\DefaultController::addCartAction"
            ]));
            $routes->add("cart_delete", new Route("/cart/delete/{id}", [
                "_controller" => "Controller\DefaultController::deleteCartAction"
            ]));
            $routes->add("category_list", new Route("/category/list", [
                "_controller" => "Controller\CategoryController::listAction"
            ]));
            $routes->add("category_add", new Route("/category/add", [
                "_controller" => "Controller\CategoryController::addAction"
            ]));
            $routes->add("category_update", new Route("/category/update/{id}", [
                "_controller" => "Controller\CategoryController::updateAction"
            ]));
            $routes->add("category_delete", new Route("/category/delete/{id}", [
                "_controller" => "Controller\CategoryController::deleteAction"
            ]));
            $routes->add("brand_list", new Route("/brand/list", [
                "_controller" => "Controller\BrandController::listAction"
            ]));
            $routes->add("brand_add", new Route("/brand/add", [
                "_controller" => "Controller\BrandController::addAction"
            ]));
            $routes->add("brand_update", new Route("/brand/update/{id}", [
                "_controller" => "Controller\BrandController::updateAction"
            ]));
            $routes->add("brand_delete", new Route("/brand/delete/{id}", [
                "_controller" => "Controller\BrandController::deleteAction"
            ]));
            $routes->add("product_list", new Route("/product/list", [
                "_controller" => "Controller\ProductController::listAction"
            ]));
            $routes->add("product_add", new Route("/product/add", [
                "_controller" => "Controller\ProductController::addAction"
            ]));
            $routes->add("product_update", new Route("/product/update/{id}", [
                "_controller" => "Controller\ProductController::updateAction"
            ]));
            $routes->add("product_delete", new Route("/product/delete/{id}", [
                "_controller" => "Controller\ProductController::deleteAction"
            ]));
            $routes->add("index", new Route("/{category}", [
                "category" => null,
                "_controller" => "Controller\DefaultController::indexAction"
            ]));
            $context = new RequestContext();
            $matcher = new UrlMatcher($routes, $context);

            $controllerResolver = new ControllerResolver();
            $argumentResolver = new ArgumentResolver();

            $dispatcher = new EventDispatcher();
            $dispatcher->addSubscriber(new RouterListener($matcher, $requestStack));

            $kernel = new HttpKernel($dispatcher, $controllerResolver, $requestStack, $argumentResolver);
            $response = $kernel->handle($request);
        } catch (ResourceNotFoundException $e) {
            $response = new Response('Not Found', 404);
        } catch (\Exception $e) {
            $response = new Response('An error occurred : '.$e->getMessage(), 500);
        }
        $response->send();
    }
}
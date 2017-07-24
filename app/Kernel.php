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
            $routes->add("test", new Route("/", [
                "_controller" => "Controller\DefaultController::indexAction"
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
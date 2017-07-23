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
            $routes->add("test", new Route("/test", [
                "_controller" => "Controller\DefaultController::testAction"
            ]));
            $routes->add("index", new Route("/{loop}", [
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
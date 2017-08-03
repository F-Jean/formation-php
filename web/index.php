<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/07/17
 * Time: 17:09
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__."/../vendor/autoload.php";


$locator = new \Symfony\Component\Config\FileLocator(array(__DIR__."/../src/Config"));
$loader = new \Symfony\Component\Routing\Loader\YamlFileLoader($locator);
$routes = $loader->load('routing.yml');

$container = new \Symfony\Component\DependencyInjection\ContainerBuilder();
$container->setParameter('routes', $routes);
$loader = new \Symfony\Component\DependencyInjection\Loader\YamlFileLoader($container, new \Symfony\Component\Config\FileLocator(__DIR__."/../app/config"));
$loader->load('services.yml');

$loader = new \Symfony\Component\DependencyInjection\Loader\YamlFileLoader($container, new \Symfony\Component\Config\FileLocator(__DIR__."/../src/Config"));
$loader->load('services.yml');


$response = $container->get("framework")->handle(\Symfony\Component\HttpFoundation\Request::createFromGlobals());

$response->send();
<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 03/08/17
 * Time: 16:30
 */

namespace Framework\Container;

/**
 * Class Templating
 * @package Framework\Container
 */
class Templating
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * Templating constructor.
     */
    public function __construct($userSession)
    {
        $loader = new \Twig_Loader_Filesystem([__DIR__.'/../../src/View']);
        $this->twig = new \Twig_Environment($loader, array(
            'cache' => false,
        ));

        $this->twig->addGlobal("session", $userSession->getUser());

        $this->twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset){
            return $asset;
        }));

        $this->twig->addFunction(new \Twig_SimpleFunction('controller', function ($controller,$action,$args = []){
            $controller = new $controller();
            $response = call_user_func_array([$controller,$action], $args);
            return $response->getContent();
        }));
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }
}
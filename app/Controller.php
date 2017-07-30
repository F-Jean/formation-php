<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/07/17
 * Time: 15:58
 */

namespace Framework;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Manager\CartManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

/**
 * Class Controller
 * @package Framework
 */
class Controller
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var EntityManager
     */
    private $doctrine;

    /**
     * @var CartManager
     */
    private $cartManager;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem([__DIR__.'/../src/View']);
        $this->twig = new \Twig_Environment($loader, array(
            'cache' => false,
        ));

        $this->twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset){
            // Gérer la notion de version
            return $asset;
        }));

        $this->twig->addFunction(new \Twig_SimpleFunction('controller', function ($controller,$action,$args = []){
            $controller = new $controller();
            $response = call_user_func_array([$controller,$action], $args);
            return $response->getContent();
        }));

        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'user'     => "root",
            'password' => "9wf23r2",
            'dbname'   => "formation-php",
            'charset'  => 'utf8',
        );
        $config = Setup::createAnnotationMetadataConfiguration([__DIR__."/../src/Entity"], false, __DIR__."/../web/cache");
        $config->setAutoGenerateProxyClasses(true);
        $this->doctrine = EntityManager::create($dbParams, $config);

        $request = Request::createFromGlobals();
        if($request->getSession() === null){
            $request->setSession(new Session());
        }
        $this->cartManager = new CartManager($request, $this->doctrine);
    }

    /**
     * @return CartManager
     */
    public function getCartManager()
    {
        return $this->cartManager;
    }

    /**
     * @return EntityManager
     */
    protected function getDoctrine()
    {
        return $this->doctrine;
    }

    /**
     * @param $filename
     * @param $data
     * @return Response
     */
    protected function render($filename, $data = [])
    {
        $template = $this->twig->load($filename);
        return new Response($template->render($data));
    }
}
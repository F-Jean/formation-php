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
use Symfony\Component\HttpFoundation\Response;

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
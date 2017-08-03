<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 03/08/17
 * Time: 16:32
 */

namespace Framework\Container;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class Doctrine
{
    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * Doctrine constructor.
     */
    public function __construct()
    {
        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'user'     => "root",
            'password' => "9wf23r2",
            'dbname'   => "formation-php",
            'charset'  => 'utf8',
        );
        $config = Setup::createAnnotationMetadataConfiguration([__DIR__."/../src/Entity"], false, __DIR__."/../../web/cache");
        $config->setAutoGenerateProxyClasses(true);
        $this->manager = EntityManager::create($dbParams, $config);
    }

    /**
     * @return EntityManager
     */
    public function getManager()
    {
        return $this->manager;
    }
}
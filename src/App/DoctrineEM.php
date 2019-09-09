<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class DoctrineEM
{
    private static $instance = null;

    private function __construct()
    {
        $config = include($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
        $configDB = $config['db'];

        // Create a simple "default" Doctrine ORM configuration
        $isDevMode = true;
        $config = Setup::createXMLMetadataConfiguration(array($_SERVER['DOCUMENT_ROOT'].'/config/xml'), $isDevMode,
            null, null, false);

        // database configuration parameters
        $conn = array(
            'driver' => 'pdo_mysql',
            'host' => $configDB['HOST'],
            'user' => $configDB['USER'],
            'password' => $configDB['PASS'],
            'dbname' => $configDB['NAME'],
            'charset' => 'UTF8',
        );

        // obtaining the entity manager
        self::$instance = EntityManager::create($conn, $config);
        return self::$instance;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            new self();
        }
        return self::$instance;
    }
}
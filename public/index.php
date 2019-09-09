<?
require_once '../vendor/autoload.php';
require_once '../src/Controller/BaseController.php';
require '../src/App/Kernel.php';
require '../src/App/DoctrineEM.php';
require '../config/config.php';
require '../config/routes.php';

use Zend\Diactoros\ServerRequestFactory;

session_start();
$kernel = new Kernel();
$kernel->initialize(ServerRequestFactory::fromGlobals());

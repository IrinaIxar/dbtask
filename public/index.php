<?
require_once '../vendor/autoload.php';
require_once '../src/Controller/BaseController.php';
require '../src/Kernel.php';
require '../src/DoctrineEM.php';
require '../src/Request.php';
require '../config/config.php';

session_start();
$request = new Request();
$kernel = new Kernel($request);
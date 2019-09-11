<?
require_once '../vendor/autoload.php';
require '../config/config.php';
require '../config/routes.php';

session_start();
$kernel = new App\Kernel();
$kernel->initialize();





<?php
declare(strict_types=1);
namespace App;
require_once(__DIR__ . '/../vendor/autoload.php');

use App\Controller\AuthController;
use App\Router\Router;

AuthController::getInstance();
$router = new Router();
$router->get('/', fn() => AuthController::getInstance()->get());
$router->post('/', fn() => AuthController::getInstance()->post());

$router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

#var_dump($_SERVER['CONTENT_TYPE']);
#$var = file_get_contents('php://input');
#var_dump($var);
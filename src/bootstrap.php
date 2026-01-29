<?php
declare(strict_types=1);
namespace Zadatak;

use Zadatak\Handler\ExceptionHandler;
require_once(__DIR__ . '/../vendor/autoload.php');

use Zadatak\Service\Session;
use Zadatak\Controller\AuthController;
use Zadatak\App\App;
use Zadatak\Router\Router;
use Zadatak\Handler\SessionHandler;
use Zadatak\Handler\ValidationHandler;
use Zadatak\Validation\UserDataValidatorFactory;

$router = new Router();
$session = new Session();

$router->get('/', [AuthController::getInstance(), 'get'])
    ->post('/', [AuthController::getInstance(), 'register'])
    ->delete('/', [AuthController::getInstance(), 'delete']);

$app = new App($router);

$app->addHandler(new ExceptionHandler())
    ->addHandler(new SessionHandler($session))
    ->addHandler(new ValidationHandler(UserDataValidatorFactory::create($session)));

$app->run();
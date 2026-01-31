<?php
declare(strict_types=1);
namespace Zadatak;

use Zadatak\Handler\ExceptionHandler;
require_once(__DIR__ . '/../vendor/autoload.php');

use Zadatak\Service\Session;
use Zadatak\Controller\AuthController;
use Zadatak\App\App;
use Zadatak\Enum\HTTPMethod;
use Zadatak\Router\Router;
use Zadatak\Handler\SessionHandler;
use Zadatak\Handler\ValidationHandler;
use Zadatak\Validation\UserDataValidatorFactory;

$router = new Router();
$session = new Session();

$router->get('/', [AuthController::getInstance(), 'get']);
$router->post('/', [AuthController::getInstance(), 'register'])
    ->addHandler(HTTPMethod::POST, new ValidationHandler(UserDataValidatorFactory::create($session)));
$router->delete('/', [AuthController::getInstance(), 'delete']);

$app = new App($router);

$app->addHandler(new ExceptionHandler())
    ->addHandler(new SessionHandler($session));

$app->run();
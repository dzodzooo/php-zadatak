<?php
declare(strict_types=1);
namespace Zadatak;
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

$router->get('/', fn() => AuthController::getInstance()->get());
$router->post('/', fn() => AuthController::getInstance()->register());
$router->delete('/', fn() => AuthController::getInstance()->delete());

$app = new App($router);

$app->addHandler(new SessionHandler($session));
$app->addHandler(new ValidationHandler(
    UserDataValidatorFactory::create($session),
    $session
));

$app->run();
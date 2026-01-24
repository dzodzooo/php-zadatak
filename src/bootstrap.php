<?php
declare(strict_types=1);
namespace App;
require_once(__DIR__ . '/../vendor/autoload.php');

use App\Database\UserRepository;
use App\Database\Database;
use App\Service\Session;
use App\Service\AuthService;
use App\Service\EmailService;
use App\TestData;
use Exception;

try {

    $testData = new TestData();
    $testData->set();
    $userData = $testData->get();

    $auth = new AuthService(
        new UserRepository(new Database()),
        new Session(),
        new EmailService()
    );

    $userId = $auth->register($userData);

    echo json_encode([
        'success' => true,
        'userId' => $userId
    ]);

} catch (Exception $exception) {
    echo "{$exception->getMessage()}\n";
}
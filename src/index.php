<?php
declare(strict_types=1);
use Service\EmailService;
require_once(__DIR__ . '/../vendor/autoload.php');

use Database\UserRepository;
use Database\Database;
use Service\Session;
use DataObject\UserData;
use Exception\DatabaseException;
use Exception\ValidationException;
use Service\AuthService;


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

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
    $_REQUEST['email'] = 'kokodf@sanel.com';
    $_REQUEST['password'] = 'password';
    $_REQUEST['confirmPassword'] = 'password';
    $_SERVER['REMOTE_ADDR'] = "152.216.7.110";
    $_SERVER['HTTP_USER_AGENT'] = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.89 Safari/537.36";
    $userData = new UserData($_REQUEST['email'], $_REQUEST['password'], $_REQUEST['confirmPassword']);

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

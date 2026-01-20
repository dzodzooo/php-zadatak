<?php
declare(strict_types=1);

require_once(__DIR__ . '/../vendor/autoload.php');

use DataObject\UserData;
use Exception\DatabaseException;
use Exception\ValidationException;
use Service\AuthService;


try {
    $_SERVER['REMOTE_ADDR'] = "152.216.7.110";
    $_SERVER['HTTP_USER_AGENT'] = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.89 Safari/537.36";

    $auth = new AuthService();
    $userId = $auth->register(new UserData('kiki@bubu.com', 'lozinka', 'lozinka'));
    echo json_encode([
        'success' => true,
        'userId' => $userId
    ]);
} catch (ValidationException | DatabaseException $exception) {
    echo "{$exception->getMessage()}\n";
}

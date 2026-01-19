<?php
declare(strict_types=1);
use Database\UserRepository;
require_once(__DIR__ . '/../vendor/autoload.php');

use DataObject\UserData;
use Exception\DatabaseException;
use Exception\ValidationException;
use Validation\UserDataValidatorFactory;

$auth = new AuthService();
$auth->register();
try {
    $userData = new UserData('user8@gmail.com', 'password', 'password');
    $validator = UserDataValidatorFactory::create($userData);
    if (!$validator->validate()) {
        $errors = $validator->getErrorMessages();
        throw new ValidationException(array_pop($errors)[0]);
    }
    $userRepository = new UserRepository();
    $userRepository->connect(username: 'my_user', password: 'my_password');
    $result = $userRepository->selectUsers('posted > NOW() - INTERVAL 10 DAY');

    var_dump($result);
    /*if (is_array($result)) {
        throw new ValidationException('User already exists');
    }

    $userId = $userRepository->insertUser($userData);
    var_dump($userId);

    $result = $userRepository->logAction(new UserLog($userId, UserAction::Register));
    echo $result;*/
} catch (ValidationException $exception) {
    echo "{$exception->getMessage()}\n";

} catch (DatabaseException $exception) {
    echo $exception->getMessage();
}




exit;
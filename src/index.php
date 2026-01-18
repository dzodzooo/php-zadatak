<?php
declare(strict_types=1);
require_once(__DIR__ . '/../vendor/autoload.php');

use Exception\DatabaseException;
use Exception\ValidationException;
use Validation\UserDataValidatorFactory;

$auth = new AuthService();
$auth->register();
try {
    $userData = new UserData('user2@gmail.com', 'password', 'password');
    $validator = UserDataValidatorFactory::create($userData);
    if (!$validator->validate()) {
        $errors = $validator->getErrorMessages();
        throw new ValidationException(array_pop($errors)[0]);
    }
    $db = new Database();
    $db->connect(username: 'my_user', password: 'my_password');

    $result = $db->selectUser($userData->email)
        ->execute();

    if (is_array($result)) {
        throw new ValidationException('User already exists');
    }

    //$result = $db->insertUser($userData);

    //if (is_array($result)) {
//  var_dump($result);
//}
} catch (ValidationException $exception) {
    echo $exception->getMessage();

} catch (DatabaseException $exception) {
    echo $exception->getMessage();
}




exit;
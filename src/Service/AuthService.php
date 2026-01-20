<?php
declare(strict_types=1);
namespace Service;

use Database\UserRepository;
use DataObject\UserData;
use DataObject\UserLog;
use Exception\DatabaseException;
use Exception\ValidationException;
use Service\Session;
use UserAction;
use Validation\UserDataValidatorFactory;
use Validation\Validator;

class AuthService
{
    private UserRepository $userRepository;
    private Session $session;
    public function __construct()
    {
        $this->session = new Session();
        $this->userRepository = new UserRepository();
        $this->userRepository->connect(username: 'my_user', password: 'my_password');

    }
    public function register(UserData $userData)
    {
        $this->session->start();

        $validator = UserDataValidatorFactory::create($userData, $this->session);
        if (!$validator->validate()) {
            $errors = $validator->getErrorMessages();
            throw new ValidationException(array_pop($errors)[0]);
        }

        $userId = $this->userRepository->insertUser($userData);
        if ($userId == 0)
            throw new DatabaseException("Couldn't insert user into database.");

        $userLog = new UserLog($userId, UserAction::Register);
        $userLogId = $this->userRepository->logAction($userLog);
        if ($userLogId == 0)
            throw new DatabaseException("Couldn't insert user log into database.");

        $this->session->regenerateId();
        $this->session->set('userId', $userId);
        return $userId;
    }
}
<?php
declare(strict_types=1);
namespace Service;

use Contract\EmailServiceInterface;
use Contract\SessionInterface;
use Contract\UserRepositoryInterface;
use DataObject\UserData;
use DataObject\UserLog;
use Exception\DatabaseException;
use Exception\ValidationException;
use UserAction;
use Validation\UserDataValidatorFactory;

class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly SessionInterface $session,
        private readonly EmailServiceInterface $mailer
    ) {
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

        $this->mailer->sendWelcomeMessage($userData->email);

        return $userId;
    }
}
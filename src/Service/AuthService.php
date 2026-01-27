<?php
declare(strict_types=1);
namespace App\Service;

use App\Contract\EmailServiceInterface;
use App\Contract\SessionInterface;
use App\Contract\UserRepositoryInterface;
use App\DataObject\UserData;
use App\DataObject\UserLog;
use App\Exception\DatabaseException;
use App\Exception\ValidationException;
use App\UserAction;
use App\Validation\UserDataValidatorFactory;

class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly EmailServiceInterface $mailer,
        private readonly SessionInterface $session
    ) {
        $this->userRepository->connect();
    }
    public function register(UserData $userData)
    {
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


        $this->mailer->sendWelcomeMessage($userData->email);

        return $userId;
    }
}
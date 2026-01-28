<?php
declare(strict_types=1);
namespace Zadatak\Service;

use Zadatak\Contract\EmailServiceInterface;
use Zadatak\Contract\SessionInterface;
use Zadatak\Contract\UserRepositoryInterface;
use Zadatak\DataObject\UserData;
use Zadatak\DataObject\UserLog;
use Zadatak\Exception\DatabaseException;
use Zadatak\Exception\ValidationException;
use Zadatak\Enum\UserAction;
use Zadatak\Validation\UserDataValidatorFactory;

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
<?php
declare(strict_types=1);
namespace Zadatak\Service;

use Zadatak\Contract\EmailServiceInterface;
use Zadatak\Contract\SessionInterface;
use Zadatak\Contract\UserMailerInterface;
use Zadatak\Contract\UserRepositoryInterface;
use Zadatak\DataObject\UserData;
use Zadatak\DataObject\UserLog;
use Zadatak\Exception\DatabaseException;
use Zadatak\Enum\UserAction;

class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserMailerInterface $mailer,
    ) {
        $this->userRepository->connect();
    }
    public function register(UserData $userData): mixed
    {
        $userId = $this->userRepository->insertUser($userData);
        if ($userId == 0)
            throw new DatabaseException("Couldn't insert user into database.");

        $userLogId = $this->userRepository->logAction(new UserLog($userId, UserAction::Register));
        if ($userLogId == 0)
            throw new DatabaseException("Couldn't insert user log into database.");

        $this->mailer->sendWelcomeMessage($userData->email);

        return $userId;
    }
}
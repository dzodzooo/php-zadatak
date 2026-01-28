<?php
declare(strict_types=1);
namespace Zadatak\Contract;

use Zadatak\DataObject\UserData;
use Zadatak\DataObject\UserLog;

interface UserRepositoryInterface
{
    public function connect();
    public function selectUser(string $email);
    public function insertUser(UserData $userData);
    public function logAction(UserLog $userLog);
    public function selectUsers(string $condition);
}
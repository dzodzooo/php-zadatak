<?php
declare(strict_types=1);
namespace App\Contract;

use App\DataObject\UserData;
use App\DataObject\UserLog;

interface UserRepositoryInterface
{
    public function connect();
    public function selectUser(string $email);
    public function insertUser(UserData $userData);
    public function logAction(UserLog $userLog);
    public function selectUsers(string $condition);
}
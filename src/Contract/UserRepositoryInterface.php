<?php
declare(strict_types=1);
namespace Contract;

use DataObject\UserData;
use DataObject\UserLog;

interface UserRepositoryInterface
{
    public function connect(string $username, string $password, string $hostname = "localhost");
    public function selectUser(string $email);
    public function insertUser(UserData $userData);
    public function logAction(UserLog $userLog);
    public function selectUsers(string $condition);
}
<?php
declare(strict_types=1);
namespace Database;

use Exception\DatabaseException;
use mysqli;
use DataObject\UserData;
use DataObject\UserLog;

class UserRepository
{
    private mysqli $mysqli;
    private QueryBuilder $queryBuilder;
    public function connect(string $username, string $password, string $hostname = "localhost")
    {
        $this->mysqli = new mysqli($hostname, $username, $password, 'my_db', 3306);
        if (!$this->mysqli or $this->mysqli->connect_errno) {
            throw new DatabaseException("Error connecting to the database.");
        }
        $this->queryBuilder = new QueryBuilder($this->mysqli);
    }
    public function selectUser(string $email)
    {
        $result = $this->queryBuilder->select('user')
            ->where('email')
            ->prepare()
            ->bindParams([$email])
            ->execute();

        return $result;
    }

    public function insertUser(UserData $userData)
    {
        $password = password_hash($userData->password, PASSWORD_BCRYPT);

        $insert_id = $this->queryBuilder
            ->insert('user')
            ->set(['email', 'password'])
            ->touch('posted')
            ->prepare()
            ->bindParams([$userData->email, $password])
            ->execute();

        return $insert_id;
    }
    public function logAction(UserLog $userLog)
    {
        $insert_id = $this->queryBuilder
            ->insert('user_log')
            ->set(['user_id', 'action'])
            ->touch('log_time')
            ->touch('posted')
            ->prepare()
            ->bindParams([$userLog->userId, $userLog->action->value])
            ->execute();


        /*mysqli_query(
            $this->mysqli,
            "INSERT INTO user_log SET `action` = 'register', user_id = $userLog->userId, log_time = NOW()"
        );
*/
        return $insert_id;
    }

    public function selectUsers(string $condition)
    {
        $result = $this->queryBuilder->select('user')
            ->where()
            ->setCondition($condition)
            ->prepare()
            ->execute();

        return $result;
    }
}
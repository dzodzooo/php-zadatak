<?php
declare(strict_types=1);
namespace App\Database;

use App\Contract\DatabaseInterface;
use App\Contract\UserRepositoryInterface;
use App\DataObject\UserData;
use App\DataObject\UserLog;

class UserRepository implements UserRepositoryInterface
{
    private QueryBuilder $queryBuilder;
    public function __construct(
        private readonly DatabaseInterface $db,
    ) {
    }
    public function connect(string $username, string $password, string $hostname = "localhost")
    {
        $this->db->connect($username, $password, $hostname);
        $this->queryBuilder = new QueryBuilder($this->db);
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
            ->touch('posted', 'NOW()')
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
            ->touch('log_time', 'NOW()')
            ->touch('posted', 'NOW()')
            ->prepare()
            ->bindParams([$userLog->userId, $userLog->action->value])
            ->execute();

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
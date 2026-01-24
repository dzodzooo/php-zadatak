<?php
declare(strict_types=1);
namespace App\Contract;

interface DatabaseInterface
{
    public function connect(string $username, string $password, string $hostname = "localhost", string $database = 'my_db', int $port = 3306);
    public function prepareStatement(string $query);
    public function escape(string $input);
    public function executeStatement(?array $args);
    public function getInsertId();
    public function bindParams(array $args);
    public function getResult();
}

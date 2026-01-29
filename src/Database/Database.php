<?php
declare(strict_types=1);
namespace Zadatak\Database;

use Zadatak\Contract\DatabaseInterface;
use Zadatak\Exception\DatabaseException;
use \mysqli;
use \mysqli_stmt;
use Zadatak\Contract\DatabaseStatementInterface;

class Database implements DatabaseInterface
{
    private mysqli $mysqli;
    public function connect(?string $hostname = null, ?string $username = null, ?string $password = null, ?string $database = null, ?int $port = null)
    {
        $this->mysqli = new mysqli(
            $hostname ?? $_ENV['DB_HOST'],
            $username ?? $_ENV['DB_USERNAME'],
            $password ?? $_ENV['DB_PASSWORD'],
            $database ?? $_ENV['DB_NAME'],
            $port ?? (int) $_ENV['DB_PORT']
        );
        if (!$this->mysqli or $this->mysqli->connect_errno) {
            throw new DatabaseException("Error connecting to the database.");
        }
    }
    public function prepareStatement(string $query): DatabaseStatementInterface
    {
        $result = $this->mysqli->prepare($query);
        if ($result === false)
            throw new DatabaseException("Couldn't prepare statement");
        return new DatabaseStatement($this, $result);
    }
    public function escape(string $input): string
    {
        return $this->mysqli->real_escape_string($input);
    }
    public function getInsertId()
    {
        return $this->mysqli->insert_id;
    }
    public function escapeArguments(array $args): array
    {
        $escaped = [];
        foreach ($args as $arg) {
            array_push($escaped, is_string($arg) ? $this->escape($arg) : $arg);
        }
        return $escaped;
    }

}
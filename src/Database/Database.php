<?php
declare(strict_types=1);
namespace App\Database;

use App\Contract\DatabaseInterface;
use App\Exception\DatabaseException;
use mysqli;
use mysqli_stmt;

class Database implements DatabaseInterface
{
    private mysqli $mysqli;
    private mysqli_stmt $statement;
    public function connect(string $username, string $password, string $hostname = "localhost", string $database = 'my_db', int $port = 3306)
    {
        $this->mysqli = new mysqli($hostname, $username, $password, $database, $port);
        if (!$this->mysqli or $this->mysqli->connect_errno) {
            throw new DatabaseException("Error connecting to the database.");
        }
    }
    public function prepareStatement(string $query)
    {
        $result = $this->mysqli->prepare($query);
        if ($result === false)
            throw new DatabaseException("Couldn't prepare statement");
        $this->statement = $result;
    }
    public function escape(string $input)
    {
        return $this->mysqli->real_escape_string($input);
    }
    public function executeStatement(?array $args)
    {
        return $this->statement->execute($args);
    }
    public function getInsertId()
    {
        return $this->mysqli->insert_id;
    }
    public function bindParams(array $args)
    {
        if (!$this->statement) {
            throw new DatabaseException("Can't bind params to unprepared statement.");
        }
        $types = "";
        $escaped = [];
        foreach ($args as $arg) {
            $type = $this->getType($arg);
            $types = "$types$type";

            if ($type === "s")
                array_push($escaped, $this->escape($arg));
            else
                array_push($escaped, $arg);
        }
        $this->statement->bind_param($types, ...$escaped);
    }

    private function getType(mixed $arg)
    {
        switch (gettype($arg)) {
            case "integer":
                return "i";
            case "float":
                return "d";
            case "string":
                return "s";
            default:
                return "b";
        }
    }
    public function getResult()
    {
        $result = $this->statement->get_result();

        if ($result === false)
            return false;

        $row = $result->fetch_assoc();

        return $row;
    }
}
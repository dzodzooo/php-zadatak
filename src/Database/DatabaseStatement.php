<?php
declare(strict_types=1);
namespace Zadatak\Database;

use mysqli_stmt;
use Zadatak\Contract\DatabaseInterface;
use Zadatak\Contract\DatabaseStatementInterface;
use Zadatak\Exception\DatabaseException;

class DatabaseStatement implements DatabaseStatementInterface
{
    public function __construct(private readonly DatabaseInterface $db, private readonly mysqli_stmt $statement)
    {
    }

    public function execute(?array $args)
    {
        return $this->statement->execute($args);
    }

    public function getResult()
    {
        $result = $this->statement->get_result();

        if ($result === false)
            return false;

        $row = $result->fetch_assoc();

        return $row;
    }
    private function getTypes(array $args): string
    {
        return implode(array_map(fn($arg) => $this->getType($arg), $args));
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
    public function bindParams(array $args)
    {
        if (!$this->statement) {
            throw new DatabaseException("Can't bind params to unprepared statement.");
        }
        $types = $this->getTypes($args);
        $escaped = array_map(fn($arg) => $this->db->escape($arg), $args);
        $this->statement->bind_param($types, ...$escaped);
    }
}
<?php
declare(strict_types=1);
namespace Database\Query;

use Exception\DatabaseException;
use mysqli;
use mysqli_stmt;

class Query
{
    protected string $query;
    protected mysqli_stmt $statement;

    public function __construct(protected mysqli $link)
    {
        $this->query = "";
    }


    public function prepare()
    {
        $this->statement = $this->link->prepare($this->query);
        return $this;
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
                array_push($escaped, $this->link->escape_string($arg));
            else
                array_push($escaped, $arg);
        }

        $this->statement->bind_param($types, ...$escaped);
        return $this;
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
    public function execute(?array $args = null)
    {
        return $this->statement->execute($args);
    }

}
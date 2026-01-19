<?php
declare(strict_types=1);
namespace Database;

use Database\Query\InsertQuery;
use Exception\DatabaseException;
use Database\Query\SelectQuery;
use mysqli;

class QueryBuilder
{
    public function __construct(private mysqli $link)
    {
    }
    public function select(string $table, ?array $columns = null)
    {
        $query = (new SelectQuery($this->link))
            ->select($columns)
            ->from($table);

        return $query;
    }
    public function insert(string $table)
    {
        $query = (new InsertQuery($this->link))
            ->insert($table);

        return $query;
    }

}
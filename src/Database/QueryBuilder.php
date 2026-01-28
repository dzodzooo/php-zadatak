<?php
declare(strict_types=1);
namespace Zadatak\Database;

use Zadatak\Contract\DatabaseInterface;
use Zadatak\Database\Query\InsertQuery;
use Zadatak\Database\Query\UpdateQuery;
use Zadatak\Database\Query\SelectQuery;

class QueryBuilder
{
    public function __construct(private DatabaseInterface $db)
    {
    }
    public function select(string $table, ?array $columns = null)
    {
        $query = (new SelectQuery($this->db))
            ->select($columns)
            ->from($table);

        return $query;
    }
    public function insert(string $table)
    {
        $query = (new InsertQuery($this->db))
            ->insert($table);

        return $query;
    }

    public function update(string $table)
    {
        $query = (new UpdateQuery($this->db))
            ->update($table);

        return $query;
    }

}
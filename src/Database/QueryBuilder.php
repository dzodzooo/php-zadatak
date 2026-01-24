<?php
declare(strict_types=1);
namespace App\Database;

use App\Contract\DatabaseInterface;
use App\Database\Query\InsertQuery;
use App\Database\Query\UpdateQuery;
use App\Database\Query\SelectQuery;

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
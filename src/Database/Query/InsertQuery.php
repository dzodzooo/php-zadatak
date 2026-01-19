<?php
declare(strict_types=1);
namespace Database\Query;
use Exception\DatabaseException;
class InsertQuery extends Query
{
    public function insert(string $table)
    {
        $table = $this->link->escape_string($table);
        $this->query = "INSERT INTO $table";
        return $this;
    }
    public function set(array $columns)
    {
        if (!str_contains($this->query, "INSERT"))
            throw new databaseexception("INSERT query must contain INSERT keyword");

        $escaped_columns = array_map(fn($column) => $this->link->escape_string($column), $columns);
        $arg = implode(", ", array_map(fn($column) => "$column = ?", $escaped_columns));
        $this->query = "$this->query SET $arg";

        return $this;
    }
    /**
     * Summary of touch
     * @param string $column sets column to NOW()
     * @throws \Exception\DatabaseException
     * @return static
     */
    public function touch(string $column)
    {
        if (!str_contains($this->query, "SET"))
            throw new databaseexception("INSERT query must contain SET keyword");
        $escaped = $this->link->escape_string($column);
        $this->query = "$this->query, $escaped=NOW()";
        return $this;
    }
    public function execute(?array $args = null)
    {
        parent::execute($args);

        return $this->link->insert_id;
    }
}
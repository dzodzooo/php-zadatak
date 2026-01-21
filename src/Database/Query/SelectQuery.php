<?php
declare(strict_types=1);
namespace Database\Query;

use Exception\DatabaseException;
class SelectQuery extends Query
{
    public function select(?array $columns = null)
    {
        if (!isset($columns)) {
            $this->query = "SELECT *";
            return $this;
        }
        $columns = array_map(fn($column) => $this->db->escape($column), $columns);
        $args = implode(', ', $columns);
        $this->query = "SELECT ({$args})";
        return $this;
    }
    public function from(string $table)
    {
        if (!str_contains($this->query, "SELECT"))
            throw new DatabaseException("SELECT query must contain SELECT keyword");

        $table = $this->db->escape($table);
        $this->query = "{$this->query} FROM {$table}";
        return $this;
    }

    public function where(?string $column = null)
    {
        if (!str_contains($this->query, "FROM"))
            throw new DatabaseException("SELECT query must contain FROM keyword");

        if ($column === null) {
            $this->query = "{$this->query} WHERE";
            return $this;
        }

        $column = $this->db->escape($column);
        $this->query = "{$this->query} WHERE {$column}=?";
        return $this;
    }
    public function and(string $column)
    {
        if (!str_contains($this->query, "WHERE"))
            throw new DatabaseException("SELECT query must contain WHERE keyword");

        $column = $this->db->escape($column);
        $this->query = "{$this->query} AND {$column}=?";
        return $this;
    }
    public function or(string $column)
    {
        if (!str_contains($this->query, "WHERE"))
            throw new DatabaseException("SELECT query must contain WHERE keyword");

        $column = $this->db->escape($column);
        $this->query = "{$this->query} OR {$column}=?";
        return $this;
    }
    public function setCondition(string $condition)
    {
        if (!str_contains($this->query, "WHERE"))
            throw new DatabaseException("SELECT query must contain WHERE keyword");

        $escaped = $this->db->escape($condition);
        $this->query = "$this->query $escaped";
        return $this;
    }
    public function execute(?array $args = null)
    {
        parent::execute($args);

        return $this->db->getResult();
    }
}
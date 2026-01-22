<?php
declare(strict_types=1);
namespace Database\Query;

use Exception\DatabaseException;

trait WhereTrait
{
    public function where(?string $column = null)
    {
        if (
            !(str_contains($this->query, 'FROM') ||
                str_contains($this->query, 'UPDATE'))
        )
            throw new DatabaseException("SELECT query must contain FROM keyword. UPDATE query must contain SET keyword");

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
}
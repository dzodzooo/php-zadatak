<?php
declare(strict_types=1);
namespace Zadatak\Database\Query;

use Zadatak\Exception\DatabaseException;

trait WhereTrait
{
    public function where(?string $column = null)
    {
        if (!str_contains($this->query, 'FROM') && !str_contains($this->query, 'UPDATE'))
            throw new DatabaseException("Invalid SELECT/UPDATE query");

        $this->query = "{$this->query} WHERE";

        if ($column !== null) {
            $this->query = "{$this->query} {$this->db->escape($column)}=?";
        }

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
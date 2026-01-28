<?php
declare(strict_types=1);
namespace Zadatak\Database\Query;

use Zadatak\Exception\DatabaseException;

trait SetTrait
{
    public function set(array $columns)
    {
        if (
            !(str_contains($this->query, "INSERT") ||
                str_contains($this->query, 'UPDATE'))
        )
            throw new DatabaseException("INSERT query must contain INSERT or UPDATE keyword");

        $escaped_columns = array_map(fn($column) => $this->db->escape($column), $columns);
        $arg = implode(", ", array_map(fn($column) => "$column = ?", $escaped_columns));
        $this->query = "$this->query SET $arg";

        return $this;
    }

    public function touch(string $column, ?string $value = null)
    {
        if (!str_contains($this->query, "SET"))
            throw new databaseexception("INSERT query must contain SET keyword");
        $escaped = $this->db->escape($column);
        $escaped_value = $this->db->escape($value);
        $this->query = "$this->query, $escaped=$escaped_value";
        return $this;
    }
}
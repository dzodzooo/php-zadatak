<?php
declare(strict_types=1);
namespace Zadatak\Database\Query;

use Zadatak\Exception\DatabaseException;
class SelectQuery extends Query
{
    use WhereTrait;
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

    public function execute(?array $args = null)
    {
        parent::execute($args);

        return $this->db->getResult();
    }
}
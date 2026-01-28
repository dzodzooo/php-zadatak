<?php
declare(strict_types=1);
namespace Zadatak\Database\Query;
class InsertQuery extends Query
{
    use SetTrait;
    public function insert(string $table)
    {
        $table = $this->db->escape($table);
        $this->query = "INSERT INTO $table";
        return $this;
    }

    public function execute(?array $args = null)
    {
        parent::execute($args);

        return $this->db->getInsertId();
    }
}
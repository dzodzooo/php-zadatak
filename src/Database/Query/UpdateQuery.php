<?php
declare(strict_types=1);
namespace Database\Query;

class UpdateQuery extends Query
{
    use SetTrait;
    use WhereTrait;

    public function update(string $table)
    {
        $escaped = $this->db->escape($table);
        $this->query = 'UPDATE $escaped';
        return $this;
    }
}
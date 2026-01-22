<?php
declare(strict_types=1);
namespace Database\Query;

use Contract\DatabaseInterface;
use Exception\DatabaseException;
use mysqli;
use mysqli_stmt;

abstract class Query
{
    protected string $query;
    protected mysqli_stmt $statement;

    public function __construct(protected readonly DatabaseInterface $db)
    {
        $this->query = "";
    }

    public function prepare()
    {
        $this->db->prepareStatement($this->query);
        return $this;
    }
    public function bindParams(array $args)
    {

        $this->db->bindParams($args);
        return $this;
    }

    public function execute(?array $args = null)
    {
        return $this->db->executeStatement($args);
    }

}
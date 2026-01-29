<?php
declare(strict_types=1);
namespace Zadatak\Database\Query;

use Zadatak\Contract\DatabaseInterface;
use mysqli_stmt;
use Zadatak\Contract\DatabaseStatementInterface;

abstract class Query
{
    protected string $query;
    protected DatabaseStatementInterface $statement;

    public function __construct(protected readonly DatabaseInterface $db)
    {
        $this->query = "";
    }

    public function prepare()
    {
        $this->statement = $this->db->prepareStatement($this->query);
        return $this;
    }
    public function bindParams(array $args)
    {
        $this->statement->bindParams($args);
        return $this;
    }

    public function execute(?array $args = null)
    {
        return $this->statement->execute($args);
    }

}
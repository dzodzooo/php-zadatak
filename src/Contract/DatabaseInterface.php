<?php
declare(strict_types=1);
namespace Zadatak\Contract;

interface DatabaseInterface
{
    public function connect();
    public function prepareStatement(string $query);
    public function escape(string $input);
    public function executeStatement(?array $args);
    public function getInsertId();
    public function bindParams(array $args);
    public function getResult();
}

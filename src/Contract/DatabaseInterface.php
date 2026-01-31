<?php
declare(strict_types=1);
namespace Zadatak\Contract;

interface DatabaseInterface
{
    public function connect();
    public function escape(string $input): mixed;
    public function getInsertId();
    public function prepareStatement(string $query): DatabaseStatementInterface;
}

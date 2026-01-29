<?php
declare(strict_types=1);
namespace Zadatak\Contract;

interface DatabaseStatementInterface
{
    public function execute(?array $args);
    public function bindParams(array $args);
    public function getResult();
}
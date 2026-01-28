<?php
declare(strict_types=1);
namespace Zadatak\DataObject;

class ScoreMock
{
    public function __construct(public readonly float $riskScore)
    {
    }
}
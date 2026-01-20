<?php
declare(strict_types=1);
namespace DataObject;

class ScoreMock
{
    public function __construct(public readonly float $riskScore)
    {
    }
}
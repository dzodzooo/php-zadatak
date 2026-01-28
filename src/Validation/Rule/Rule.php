<?php
declare(strict_types=1);
namespace Zadatak\Validation\Rule;
abstract class Rule
{
    protected string $errorMessage;
    public function __construct()
    {
        $this->errorMessage = "";
    }
    abstract public function validate(array $data, string $key): bool;
    public function getMessage(): string
    {
        return $this->errorMessage;
    }
}
<?php
declare(strict_types=1);
namespace Zadatak\Validation\Rule;
class EmailRule extends Rule
{
    public function __construct()
    {
        parent::__construct();
    }
    public function validate(array $data, string $key): bool
    {
        $validated = filter_var($data[$key], FILTER_VALIDATE_EMAIL);
        if (false === $validated || null === $validated) {
            $this->errorMessage = "Invalid email.";
            return false;
        }
        return true;
    }
}
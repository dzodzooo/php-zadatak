<?php
declare(strict_types=1);
namespace App\Validation\Rule;
class EmailRule extends Rule
{
    public function __construct()
    {
        parent::__construct();
    }
    public function validate(string $input): bool
    {
        $validated = filter_var($input, FILTER_VALIDATE_EMAIL);
        if (false === $validated || null === $validated) {
            $this->errorMessage = "Invalid email.";
            return false;
        }
        return true;
    }
}
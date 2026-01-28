<?php
declare(strict_types=1);
namespace Zadatak\Validation\Rule;
class RequiredRule extends Rule
{
    public function __construct()
    {
        parent::__construct();
    }
    public function validate(string $input): bool
    {
        if (isset($input) && strlen($input) > 0) {
            $this->errorMessage = "";
            return true;
        }
        $this->errorMessage = 'Input must not be empty.';
        return false;
    }
}
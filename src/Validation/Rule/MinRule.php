<?php
declare(strict_types=1);
namespace App\Validation\Rule;

use App\Exception\ValidationException;

class MinRule extends Rule
{
    private int $min;

    public function __construct(array $args)
    {
        parent::__construct();
        if (!isset($args))
            throw new ValidationException('Invalid arguments.');

        if (!isset($args['min']))
            throw new ValidationException('Arguments array must contain key "min".');

        $this->min = $args['min'];
    }
    public function validate(string $input): bool
    {
        if (mb_strlen($input) > $this->min) {
            $this->errorMessage = "";
            return true;
        }
        $this->errorMessage = "Input must be of minimum length {$this->min}.";
        return false;
    }
}
<?php
declare(strict_types=1);
namespace Zadatak\Validation\Rule;

use Zadatak\Exception\ValidationException;

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
    public function validate(array $data, string $key): bool
    {
        if (mb_strlen($data[$key]) > $this->min) {
            $this->errorMessage = "";
            return true;
        }
        $this->errorMessage = "Input must be of minimum length {$this->min}.";
        return false;
    }
}
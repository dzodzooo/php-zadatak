<?php
declare(strict_types=1);
namespace Zadatak\Validation\Rule;

use Zadatak\Exception\ValidationException;

class SameRule extends Rule
{
    private string $sameAs;
    public function __construct(array $args)
    {
        parent::__construct();
        if (!isset($args))
            throw new ValidationException('Invalid arguments.');

        if (!isset($args['same']))
            throw new ValidationException('Arguments array must contain key "same".');

        $this->sameAs = $args['same'];
    }
    public function validate(array $data, string $key): bool
    {
        if ($data[$key] === $data[$this->sameAs]) {
            $this->errorMessage = "";
            return true;
        }
        $this->errorMessage = "Input must be same as {$data[$this->sameAs]}.";
        return false;
    }
}
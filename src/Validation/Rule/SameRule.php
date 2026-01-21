<?php
declare(strict_types=1);
namespace Validation\Rule;

use Exception\ValidationException;

class SameRule extends Rule
{
    private array $arg;
    public function __construct(array $args)
    {
        parent::__construct();
        $this->arg = [];
        if (!isset($args))
            throw new ValidationException('Invalid arguments.');

        if (!isset($args['same']))
            throw new ValidationException('Arguments array must contain key "same".');

        if (!isset($args['subject'][$args['same']]))
            throw new ValidationException("Field {$args['same']} doesn't exist on subject.");
        $this->arg['key'] = $args['same'];
        $this->arg['value'] = $args['subject'][$args['same']];
    }
    public function validate(string $input): bool
    {
        if ($input === $this->arg['value']) {
            $this->errorMessage = "";
            return true;
        }
        $this->errorMessage = "Input must be same as {$this->arg['key']}.";
        return false;
    }
}
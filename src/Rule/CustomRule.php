<?php
declare(strict_types=1);
namespace Rule;

use Exception;
use Exception\ValidationException;

class CustomRule extends Rule
{
    private $callback;
    public function __construct(callable $callback)
    {
        if (!is_callable($callback)) {
            throw new ValidationException("");
        }
        $this->callback = $callback;
    }
    public function validate(string $input): bool
    {
        return call_user_func($this->callback, $input);
    }
}
<?php
declare(strict_types=1);
namespace Rule;
use Exception;
class EmailRule extends Rule
{
    public function __construct(array $args)
    {
        parent::__construct();
    }
    public function validate(string $input): bool
    {
        throw new Exception('Not implemented yet');
    }
}
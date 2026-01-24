<?php
declare(strict_types=1);
namespace App\Validation\Rule;

use App\Exception\ValidationException;

class RuleFactory
{
    public static function create(string $rule, ?array $args = null): Rule
    {
        switch ($rule) {
            case 'email':
                return new EmailRule();
            case 'required':
                return new RequiredRule();
            case 'min':
                return new MinRule($args);
            case 'same':
                return new SameRule($args);
            case 'unique email':
                return new UniqueEmailRule();
            case 'minfraud':
                return new MinfraudRule($args);

            default:
                throw new ValidationException("Unimplemented rule $rule");

        }
    }
}
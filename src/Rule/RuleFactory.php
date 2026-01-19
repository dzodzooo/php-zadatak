<?php
declare(strict_types=1);
namespace Rule;

class RuleFactory
{
    public static function create(string $rule, ?array $args = null, ?callable $callback = null): Rule
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

            default:
                return new CustomRule($callback);

        }
    }
}
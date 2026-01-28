<?php
declare(strict_types=1);
namespace Zadatak\Validation;

use Zadatak\Exception\ValidationException;
use Zadatak\Validation\Rule\RequiredRule;
use Zadatak\Validation\Rule\Rule;
use Zadatak\Validation\Rule\RuleFactory;

class Validator
{
    private array $subject;
    private array $rules;
    private array $errorMessages;
    public function __construct()
    {
        $this->rules = [];
        $this->errorMessages = [];
    }

    public function validateOn(array $subject)
    {
        $this->subject = $subject;
    }

    public function addRule(string $key, string $rule, ?array $args = null)
    {
        //$args = $args !== null ? array_merge(['subject' => $this->subject], $args) : $args;
        $rule = RuleFactory::create($rule, $args);

        if (!isset($this->rules[$key]))
            $this->rules[$key] = [];

        array_push($this->rules[$key], $rule);
    }

    public function validate(): bool
    {
        if (!isset($this->subject))
            throw new ValidationException("Subject of validation not set.");

        $validated = true;
        foreach ($this->rules as $key => $rules) {
            if (!isset($this->subject[$key])) {
                throw new ValidationException("Key {$key} does not exist.");
            }
            foreach ($rules as $rule) {
                if (!$rule->validate($this->subject, $key)) {
                    $validated = false;
                    $this->addErrorMessage($key, $rule);
                }
            }
        }
        return $validated;
    }
    private function addErrorMessage(string $key, Rule $rule)
    {
        if (isset($this->errorMessages[$key]))
            array_push($this->errorMessages[$key], $rule->getMessage());
        else
            $this->errorMessages[$key] = [$rule->getMessage()];
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }
}
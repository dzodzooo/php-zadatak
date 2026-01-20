<?php
declare(strict_types=1);
namespace Validation;

use Exception\ValidationException;
use Rule\Rule;
use Rule\RuleFactory;

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
        foreach ($subject as $key => $value) {
            $this->rules[$key] = [];
        }
    }

    public function addRule(string $key, string $rule, ?array $args = null)
    {
        if (!isset($this->subject)) {
            throw new ValidationException('Array to be validated not set. Set with $validator->validateOn($array)');
        }
        if (!isset($this->subject[$key])) {
            throw new ValidationException("Key {$key} does not exist.");
        }
        $args = $args !== null ? array_merge(['subject' => $this->subject], $args) : $args;
        $rule = RuleFactory::create($rule, $args);
        array_push($this->rules[$key], $rule);
    }

    public function validate(): bool
    {
        $validated = true;
        foreach ($this->rules as $key => $rules) {
            foreach ($rules as $rule) {
                if (!$rule->validate($this->subject[$key])) {
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
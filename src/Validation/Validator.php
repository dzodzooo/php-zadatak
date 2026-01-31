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
    private array $fields;
    private array $errorMessages;
    public function __construct()
    {
        $this->fields = [];
        $this->errorMessages = [];
    }

    public function validateOn(array $subject)
    {
        $this->subject = $subject;
    }

    public function addRule(string $field, string $rule, ?array $args = null)
    {
        $rule = RuleFactory::create($rule, $args);

        if (!isset($this->fields[$field]))
            $this->fields[$field] = [];

        array_push($this->fields[$field], $rule);
    }

    public function validate(): bool
    {
        $this->assertCanValidate();

        $valid = true;
        foreach ($this->fields as $field => $rules) {
            if (!$this->validateField($rules, $field)) {
                $valid = false;
            }
        }
        return $valid;
    }
    private function validateField(array $rules, string $field): bool
    {
        $validated = true;
        foreach ($rules as $rule) {
            if (!$rule->validate($this->subject, $field)) {
                $validated = false;
                $this->addErrorMessage($field, $rule);
            }
        }
        return $validated;
    }
    private function assertCanValidate()
    {
        if (!isset($this->subject))
            throw new ValidationException("Subject of validation not set.");

        foreach ($this->fields as $field => $rules) {
            if (!isset($this->subject[$field])) {
                throw new ValidationException("Key {$field} does not exist.");
            }
        }
    }
    private function addErrorMessage(string $field, Rule $rule)
    {
        if (!isset($this->errorMessages[$field]))
            $this->errorMessages[$field] = [];

        array_push($this->errorMessages[$field], $rule->getMessage());
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }
}
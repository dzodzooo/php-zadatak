<?php
declare(strict_types=1);
namespace Zadatak\DataObject;

class Email
{
    private ?string $to;
    private ?string $subject;
    private ?string $message;

    public function setTo(string $to)
    {
        $this->to = $to;
        return $this;
    }
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
        return $this;
    }
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }
    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        }
        return null;
    }
}
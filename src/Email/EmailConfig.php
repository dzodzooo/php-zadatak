<?php
declare(strict_types=1);
namespace Zadatak\Email;

class EmailConfig
{
    private array $additionalHeaders;
    public function __construct()
    {
        $this->additionalHeaders = [];
    }
    public function setHeader(string $key, string $value)
    {
        $this->additionalHeaders[$key] = $value;
        return $this;
    }

    public function __get($name)
    {
        return $this->$name ?? null;
    }

}
<?php
declare(strict_types=1);
namespace Zadatak\Handler\Request;

use Zadatak\Exception\BadRequestException;

class Request
{
    private array $attributes;
    private ?array $body;
    public function __construct()
    {
        $this->attributes = [];
        $this->body = null;
    }

    public function get(string $key)
    {
        if (!isset($this->attributes))
            throw new BadRequestException("No such attribute $key in request object.");

        return $this->attributes[$key];
    }

    public function withAttribute(string $key, mixed $value)
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    public function withBody(array $body)
    {
        $this->body = $body;
    }
    public function getBody()
    {
        return $this->body;
    }
}
<?php
declare(strict_types=1);
namespace Zadatak\DataObject;

use Zadatak\Exception\BadRequestException;

class Request
{
    private array $attributes;

    public function __construct()
    {
        $this->attributes = [];
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
}
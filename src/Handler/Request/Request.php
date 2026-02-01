<?php
declare(strict_types=1);
namespace Zadatak\Handler\Request;

use Zadatak\Contract\RequestInterface;
use Zadatak\Exception\BadRequestException;

class Request implements RequestInterface
{
    private array $attributes;
    private ?array $body;
    public function __construct()
    {
        $this->attributes = [];
        $this->body = null;
    }

    public function withAttribute(string $key, mixed $value): static
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    public function withBody(array $body): static
    {
        $this->body = $body;
        return $this;
    }
    public function get(string $key): mixed
    {
        if (!isset($this->attributes))
            throw new BadRequestException("No such attribute $key in request object.");

        return $this->attributes[$key];
    }
    public function getBody(): array|null
    {
        if ($this->body === null)
            $this->body = $this->getBodyFromContentType();

        return $this->body;
    }
    private function getBodyFromContentType()
    {
        switch ($this->getServerParams()['CONTENT_TYPE']) {
            case "application/json":
                return $this->getBodyAsJSON();
            case "multipart/form-data":
            case "application/x-www-form-urlencoded":
                return request_parse_body();
            default:
                return null;
        }
    }
    private function getBodyAsJSON()
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData);
        return (array) $data;
    }
    public function getServerParams()
    {
        return $_SERVER;
    }
}
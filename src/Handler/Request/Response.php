<?php
declare(strict_types=1);
namespace Zadatak\Handler\Request;
use Zadatak\Contract\ResponseInterface;
use Zadatak\Enum\StatusCode;

class Response implements ResponseInterface
{
    public function withHeader(string $header, string $value): static
    {
        header("$header: $value", true);
        return $this;
    }
    public function withStatusCode(StatusCode $statusCode): static
    {
        http_response_code($statusCode->value);
        return $this;
    }
    public function withBody(string $body): static
    {
        echo $body;
        return $this;
    }
}
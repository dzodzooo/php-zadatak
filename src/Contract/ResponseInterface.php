<?php
declare(strict_types=1);
namespace Zadatak\Contract;

use Zadatak\Enum\StatusCode;

interface ResponseInterface
{
    public function withHeader(string $header, string $value): static;
    public function withBody(string $body): ResponseInterface;
    public function withStatusCode(StatusCode $statusCode): static;
}
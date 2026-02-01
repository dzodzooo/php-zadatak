<?php
declare(strict_types=1);
namespace Zadatak\Contract;

interface RequestInterface
{
    public function withAttribute(string $key, mixed $value): static;
    public function withBody(array $body): static;
    public function getServerParams();
    public function get(string $key): mixed;
    public function getBody(): array|null;
}
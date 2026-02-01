<?php
declare(strict_types=1);
namespace Zadatak\Contract;

use Zadatak\Contract\RequestInterface;

interface HandlerInterface
{
    public function setHandler(HandlerInterface $handler);

    public function handle(RequestInterface $request): ResponseInterface;
}
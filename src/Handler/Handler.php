<?php
declare(strict_types=1);
namespace Zadatak\Handler;

use Zadatak\Contract\HandlerInterface;
use Zadatak\Contract\RequestInterface;
use Zadatak\Contract\ResponseInterface;

abstract class Handler implements HandlerInterface
{
    protected HandlerInterface $handler;
    public function setHandler(HandlerInterface $handler)
    {
        $this->handler = $handler;
    }
    public abstract function handle(RequestInterface $request): ResponseInterface;
}
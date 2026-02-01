<?php
declare(strict_types=1);
namespace Zadatak\Handler;

use Zadatak\Contract\HandlerInterface;
use Zadatak\Contract\RequestInterface;
use Zadatak\Contract\ResponseInterface;
use Zadatak\Handler\Request\Response;

class RequestHandler extends Handler implements HandlerInterface
{
    private $callback;
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }
    public function handle(RequestInterface $request): ResponseInterface
    {
        return ($this->callback)($request);
    }
}
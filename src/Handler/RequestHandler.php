<?php
declare(strict_types=1);
namespace Zadatak\Handler;

use Zadatak\Contract\HandlerInterface;

class RequestHandler extends Handler implements HandlerInterface
{
    private $callback;
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }
    public function handle($request)
    {
        return ($this->callback)($request);
    }
}
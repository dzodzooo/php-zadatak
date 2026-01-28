<?php
declare(strict_types=1);
namespace Zadatak\Handler;

use Zadatak\Contract\HandlerInterface;
use Zadatak\DataObject\Request;
use Zadatak\DataObject\Response;

class RequestHandler extends Handler implements HandlerInterface
{
    private $callback;
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }
    public function handle(Request $request)
    {
        ($this->callback)($request);
    }
}
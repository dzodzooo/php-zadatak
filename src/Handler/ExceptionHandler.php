<?php
declare(strict_types=1);
namespace Zadatak\Handler;

use Zadatak\Contract\HandlerInterface;
use Zadatak\Exception\RouteException;
use Zadatak\Exception\ValidationException;
use Zadatak\Handler\Request\Request;

class ExceptionHandler extends Handler implements HandlerInterface
{
    public function handle(Request $request)
    {
        try {
            $this->handler->handle($request);
        } catch (ValidationException $exception) {
            echo $exception->getMessage();
        }
    }
}
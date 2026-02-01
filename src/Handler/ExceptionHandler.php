<?php
declare(strict_types=1);
namespace Zadatak\Handler;

use Zadatak\Contract\HandlerInterface;
use Zadatak\Contract\RequestInterface;
use Zadatak\Contract\ResponseInterface;
use Zadatak\Enum\StatusCode;
use Zadatak\Exception\ValidationException;
use Zadatak\Handler\Request\Response;

class ExceptionHandler extends Handler implements HandlerInterface
{
    public function handle(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->handler->handle($request);
        } catch (ValidationException $exception) {
            return (new Response())
                ->withStatusCode(StatusCode::BAD_REQUEST)
                ->withBody($exception->getMessage());
        }
    }
}
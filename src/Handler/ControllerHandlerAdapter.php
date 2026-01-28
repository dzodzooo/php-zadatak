<?php
declare(strict_types=1);
namespace Zadatak\Handler;

class ControllerHandlerAdapter extends Handler
{
    private $callback;
    private array $callback_args;
    public function __construct(callable $callback, array $callback_args)
    {
        $this->callback = $callback;
        $this->callback_args = $callback_args;
    }
    public function handle($request)
    {
        return ($this->callback)($this->callback_args);
    }
}

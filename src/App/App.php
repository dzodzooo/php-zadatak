<?php
declare(strict_types=1);
namespace Zadatak\App;

use Zadatak\Contract\HandlerInterface;
use Zadatak\Router\Router;

class App
{
    private array $handlers;
    public function __construct(private readonly Router $router)
    {
        $this->handlers = [];
    }

    public function addHandler(HandlerInterface $handler)
    {
        array_push($this->handlers, $handler);
    }

    public function run()
    {
        $requestHandler = $this->router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
        $handler = $this->chainHandlers($requestHandler);
        $handler->handle([]);
    }
    private function chainHandlers(HandlerInterface $requestHandler): HandlerInterface
    {
        if (count($this->handlers) == 0)
            return $requestHandler;

        $count = count($this->handlers);
        for ($i = 0; $i < $count - 1; $i++) {
            $this->handlers[$i]->setHandler($this->handlers[$i + 1]);
        }
        $this->handlers[$count - 1] = $requestHandler;
        return $this->handlers[0];
    }

}
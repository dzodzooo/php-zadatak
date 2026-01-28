<?php
declare(strict_types=1);
namespace Zadatak\App;

use Zadatak\Contract\HandlerInterface;
use Zadatak\DataObject\Request;
use Zadatak\Handler\RequestHandler;
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
        $handler = $this->getHandler($requestHandler);
        $handler->handle(new Request());
    }
    private function getHandler(HandlerInterface $requestHandler): HandlerInterface
    {
        if (count($this->handlers) == 0)
            return $requestHandler;
        else
            return $this->chainHandlers($requestHandler);
    }
    private function chainHandlers(HandlerInterface $requestHandler): HandlerInterface
    {
        $count = count($this->handlers);
        for ($i = 0; $i < $count - 1; $i++) {
            $this->handlers[$i]->setHandler($this->handlers[$i + 1]);
        }
        $this->handlers[$count - 1]->setHandler($requestHandler);
        return $this->handlers[0];
    }

}
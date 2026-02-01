<?php
declare(strict_types=1);
namespace Zadatak\App;

use Zadatak\Contract\HandlerInterface;
use Zadatak\Exception\RouteException;
use Zadatak\Handler\Request\Request;
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
        return $this;
    }

    public function run()
    {
        try {
            $this->tryRun();
        } catch (RouteException $exception) {
            echo $exception->getMessage();
        }
    }
    private function tryRun()
    {
        $request = new Request();

        $requestHandler = $this->router->resolve(
            $request->getServerParams()['REQUEST_URI'],
            $request->getServerParams()['REQUEST_METHOD']
        );

        $this->addHandler($requestHandler)
            ->chainHandlers()
            ->handle($request);
    }
    private function chainHandlers(): HandlerInterface
    {
        $count = count($this->handlers);
        for ($i = 0; $i < $count - 1; $i++) {
            $this->handlers[$i]->setHandler($this->handlers[$i + 1]);
        }
        return $this->handlers[0];
    }

}
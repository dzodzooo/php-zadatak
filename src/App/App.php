<?php
declare(strict_types=1);
namespace Zadatak\App;

use Zadatak\Contract\HandlerInterface;
use Zadatak\Router\Router;

class App
{
    private ?HandlerInterface $head = null;
    private ?HandlerInterface $tail = null;
    public function __construct(private readonly Router $router)
    {
    }

    public function addHandler(HandlerInterface $handler)
    {
        if ($this->tail === null) {
            $this->tail = $handler;
        }

        if ($this->head !== null)
            $handler->setHandler($this->head);

        $this->head = $handler;
    }

    public function run()
    {
        $requestHandler = $this->router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
        if ($this->tail !== null) {
            $this->tail->setHandler($requestHandler);
            $this->head->handle([]);
        } else {
            $requestHandler->handle([]);
        }
    }

}
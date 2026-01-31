<?php
declare(strict_types=1);
namespace Zadatak\Router;

use Zadatak\Contract\HandlerInterface;
use Zadatak\Enum\HTTPMethod;
use Zadatak\Exception\RouteException;
use Zadatak\Handler\Handler;
use Zadatak\Handler\RequestHandler;

/**
 * Summary of Route
 * @property string $path
 * @property RequestHandler $GET GET request handler for this route.
 * @property RequestHandler $POST POST request handler for this route. 
 * @property RequestHandler $DELETE DELETE request handler for this route.
 * @property RequestHandler $UPDATE UPDATE request handler for this route.
 */
class Route
{
    private HandlerInterface $GET;
    private HandlerInterface $POST;
    private HandlerInterface $DELETE;
    private HandlerInterface $UPDATE;
    public function __construct(private string $path)
    {
    }

    public function setHandler(HTTPMethod $method, callable $callback): static
    {
        $this->{$method->value} = new RequestHandler($callback);
        return $this;
    }
    public function addHandler(HTTPMethod $method, HandlerInterface $handler): static
    {
        if (isset($this->{$method->value})) {
            $handler->setHandler($this->{$method->value});
            $this->{$method->value} = $handler;
            return $this;
        }
        throw new RouteException("Can't add handler");
    }
    public function __get($name)
    {
        if (isset($this->$name))
            return $this->$name;
        throw new \Exception("No such property.");
    }
}
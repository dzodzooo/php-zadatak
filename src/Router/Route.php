<?php
declare(strict_types=1);
namespace Zadatak\Router;

use Zadatak\Enum\HTTPMethod;
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
    public Handler $GET;
    public Handler $POST;
    public Handler $DELETE;
    public Handler $UPDATE;
    public function __construct(public string $path)
    {
    }

    public function setHandler(HTTPMethod $method, callable $callback): static
    {
        $this->{$method->value} = new RequestHandler($callback);
        return $this;
    }
}
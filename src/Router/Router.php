<?php
declare(strict_types=1);
namespace Zadatak\Router;

use Zadatak\Enum\HTTPMethod;
use Zadatak\Exception\RouteException;
class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = array();
    }

    private function register(string $route, HTTPMethod $method, callable $callback)
    {
        if (!isset($this->routes[$route]))
            $this->routes[$route] = new Route($route);

        $this->routes[$route]->setHandler($method, $callback);
    }
    public function post(string $route, $callback)
    {
        $this->register($route, HTTPMethod::POST, $callback);
    }
    public function get(string $route, $callback)
    {
        $this->register($route, HTTPMethod::GET, $callback);
    }
    public function update(string $route, $callback)
    {
        $this->register($route, HTTPMethod::UPDATE, $callback);
    }
    public function delete(string $route, $callback)
    {
        $this->register($route, HTTPMethod::DELETE, $callback);
    }
    public function resolve(string $url, string $method, mixed $request = null)
    {
        $route = parse_url($url, PHP_URL_PATH);
        $query = parse_url($url, PHP_URL_QUERY) ?? '';

        if (!isset($this->routes[$route])) {
            throw new RouteException("Route $route not registered.");
        }

        parse_str($query, $params);

        return $this->routes[$route]->$method;
    }

}
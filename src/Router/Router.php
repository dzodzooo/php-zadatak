<?php
declare(strict_types=1);
namespace App\Router;

class Router
{
    public array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function register(string $route, callable $callback)
    {
        $this->routes[$route] = $callback;
    }
    public function resolve(string $uri, string $method)
    {
        $uri = explode("?", $uri);
        $route = $uri[0];
        if (!isset($this->routes[$route])) {
            throw new \RuntimeException("Route not registered");
        }
        $args = isset($uri[1]) ? $this->parseQueryString($uri[1]) : [];
        call_user_func_array($this->routes[$route], $args);
    }
    private function parseQueryString(string $query_string)
    {
        $args = [];
        $params = explode("&", $query_string);
        foreach ($params as $param) {
            [$key, $value] = explode("=", $param);
            $args[$key] = $value;
        }
        return $args;
    }

}
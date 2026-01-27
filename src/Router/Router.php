<?php
declare(strict_types=1);
namespace App\Router;

use App\Enum\HTTPMethod;
use RuntimeException;

class Router
{
    private array $GET;
    private array $POST;
    private array $DELETE;
    private array $UPDATE;

    public function __construct()
    {
        $this->GET = [];
        $this->POST = [];
        $this->DELETE = [];
        $this->UPDATE = [];
    }

    private function register(string $route, string $method, callable $callback)
    {
        if (null === HTTPMethod::tryFrom($method))
            throw new RuntimeException("Method must be GET/POST/UPDATE/DELETE");

        $this->$method[$route] = $callback;
    }
    public function post(string $route, $callback)
    {
        $this->register($route, HTTPMethod::POST->value, $callback);
    }
    public function get(string $route, $callback)
    {
        $this->register($route, HTTPMethod::GET->value, $callback);
    }
    public function update(string $route, $callback)
    {
        $this->register($route, HTTPMethod::UPDATE->value, $callback);
    }
    public function delete(string $route, $callback)
    {
        $this->register($route, HTTPMethod::DELETE->value, $callback);
    }
    public function resolve(string $uri, string $method)
    {
        $uri = explode("?", $uri);
        $route = $uri[0];
        assert($this->routeExists($route, $method));

        $args = isset($uri[1]) ? $this->parseQueryString($uri[1]) : [];

        call_user_func_array($this->$method[$route], $args);
    }
    public function routeExists(string $route, string $method)
    {
        if (!isset($this->$method[$route])) {
            throw new RuntimeException("Route not registered");
        }
        return true;
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
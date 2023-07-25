<?php

namespace Core;

class Router
{
    public $routes = [
        'get' => [],
        'post' => []
    ];

    public static function load($file)
    {
        $router = new static;
        require $file;
        return $router;
    }

    public function get($uri, $controller)
    {
        $this->routes['get'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['post'][$uri] = $controller;
    }

    public function direct($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }
        throw new \Exception('No route defined for this URI');
    }

    protected function callAction($controller, $action)
    {
        $controller = "app\\controllers\\" . $controller;
        $controller = new $controller;
        if (!method_exists($controller, $action)) {
            throw new \Exception("Action not exist");
        }
        return $controller->$action();
    }
}
<?php

namespace Engine\Router;

class Route
{
    use URLParser;

    protected $routes = [];

    protected $currentRoute = -1;

    public function get($uri, $controller, $method)
    {
        $this->routes[] = [
            'uri' => $this->sanitize($uri),
            'path' => $this->parsePath($uri),
            'params' => $this->parseParams($uri),
            'controller' => $controller,
            'method' => $method,
            'type' => 'GET'
        ];

        $this->currentRoute++;

        return $this;
    }

    public function post($uri, $controller, $method)
    {
        $this->routes[] = [
            'uri' => $this->sanitize($uri),
            'path' => $this->parsePath($uri),
            'params' => $this->parseParams($uri),
            'controller' => $controller,
            'method' => $method,
            'type' => 'POST'
        ];

        $this->currentRoute++;

        return $this;
    }

    public function name($name)
    {
        $this->routes[$this->currentRoute]['name'] = $name;

        return $this;
    }

    public function middleware($middleware)
    {
        $this->routes[$this->currentRoute]['middleware'] = $middleware;

        return $this;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function group($options, $callback)
    {
        $route = new Route();

        $callback($route);

        $routes = $route->getRoutes();

        foreach ($routes as $key => $value) {
            $routes[$key]['uri'] = $options['prefix'] . $value['uri'];
        }

        $this->routes = array_merge($this->routes, $routes);
    }
}

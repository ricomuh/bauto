<?php

namespace Engine\Router;

class Route
{
    use URLParser;

    protected $routes = [];

    protected $currentRoute = -1;

    /**
     * Add GET route
     * 
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @return Route
     */
    public function get($uri, $controller, $method)
    {
        return $this->addRoute($uri, $controller, $method, 'GET');
    }

    /**
     * Add POST route
     * 
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @return Route
     */
    public function post($uri, $controller, $method)
    {
        return $this->addRoute($uri, $controller, $method, 'POST');
    }

    /**
     * Add PUT route
     * 
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @return Route
     */
    public function put($uri, $controller, $method)
    {
        return $this->addRoute($uri, $controller, $method, 'PUT');
    }

    /**
     * Add DELETE route
     * 
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @return Route
     */
    public function delete($uri, $controller, $method)
    {
        return $this->addRoute($uri, $controller, $method, 'DELETE');
    }

    /**
     * Add route
     * 
     * @param string $uri
     * @param string $controller
     * @param string $method
     * @param string $type
     * @return Route
     */
    public function addRoute($uri, $controller, $method, $type)
    {
        $this->routes[] = [
            'uri' => $this->sanitize($uri),
            'path' => $this->parsePath($uri),
            'params' => $this->parseParams($uri),
            'controller' => $controller,
            'method' => $method,
            'type' => $type
        ];

        $this->currentRoute++;

        return $this;
    }

    /**
     * Add name to route
     * 
     * @param string $name
     * @return Route
     */
    public function name($name)
    {
        $this->routes[$this->currentRoute]['name'] = $name;

        return $this;
    }

    /**
     * Add middleware to route
     * 
     * @param string $middleware
     * @return Route
     */
    public function middleware($middleware)
    {
        $this->routes[$this->currentRoute]['middleware'] = $middleware;

        return $this;
    }

    /**
     * Get routes
     * 
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Group routes
     * 
     * @param array $options
     * @param callable $callback
     * @return void
     */
    public function group(array $options, callable $callback)
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

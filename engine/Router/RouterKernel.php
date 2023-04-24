<?php

namespace Engine\Router;

use Engine\Handler\Request;
use Engine\Handler\Response\RedirectResponse;

class RouterKernel
{
    use URLParser;

    public $route;
    public $request;

    /**
     * RouterKernel constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->route = new Route();
        $this->request = new Request();
    }

    /**
     * Application routes
     * 
     * @param Route $route
     * @return void
     */
    public function application(Route $route)
    {
    }

    /**
     * Handle the request
     * 
     * @return void
     */
    public function handle()
    {
        $this->application($this->route);
        $routes = $this->route->getRoutes();

        $returned = $this->checkRoute($routes, function ($route, $params) {
            $paramsValues = [];
            foreach ($params as $param) {
                $paramsValues[] = $this->request->path[$param['index']];
            }

            $paramsValues[] = $this->request;

            $this->runMethod($route['controller'], $route['method'], $paramsValues);
        });

        if (!$returned) {
            echo abort(404);
        }
    }

    /**
     * Check the route
     * 
     * @param array $routes
     * @param callable $callback
     * @return bool
     */
    public function checkRoute(array $routes, callable $callback)
    {
        foreach ($routes as $route) {
            if (count($route['path']) != count($this->request->path)) continue;
            if ($route['type'] != $this->request->method()) continue;

            $matchedPath = 0;
            $params = [];

            foreach ($route['path'] as $key => $path) {
                if ($path == $this->request->path[$key]) {
                    $matchedPath++;
                } else if (preg_match('/^:/', $path)) {
                    $params[] = [
                        'index' => $key,
                        'name' => preg_replace('/^:/', '', $path),
                    ];
                    $matchedPath++;
                }
            }

            if ($matchedPath == count($route['path'])) {
                $callback($route, $params);

                return true;
            }
        }

        return false;
    }

    /**
     * Run the controller method
     * 
     * @param string $controller
     * @param string $method
     * @param array $params
     * @return void
     */
    public function runMethod($controller, $method, $params)
    {
        $controller = new $controller();
        $response = $controller->$method(...$params);

        if ($response instanceof RedirectResponse) {
            $response->render();
        } else {
            echo $response;
        }
    }
}

<?php

namespace Engine\Router;

use Engine\Handler\Request;

class RouterKernel
{
    use URLParser;

    public $route;
    public $request;

    public function __construct()
    {
        $this->route = new Route();
        $this->request = new Request();
    }

    public function application(Route $route)
    {
    }

    public function handle()
    {
        $this->application($this->route);
        $routes = $this->route->getRoutes();

        $this->checkForControllerAndMethod($routes, function ($route, $params) {
            $controller = new $route['controller']();
            $method = $route['method'];
            // $controller->$method(...$params);
            $response = $controller->$method(...$params);

            if (is_string($response)) {
                echo $response;
            } else {
                echo $response;
            }
        });

        // echo json_encode($this->request->url());
        // echo json_encode($routes);

        // foreach ($routes as $route) {
        //     if ($route['uri'] == $this->request->url() && $route['type'] == $this->request->method()) {
        //         $controller = new $route['controller']();

        //         $params = [];
        //         foreach ($route['params'] as $param) {
        //             $params[] = $this->request->get($param);
        //         }

        //         $method = $route['method'];
        //         $controller->$method(...$params);

        //         // echo "Controller: {$route['controller']} <br> Method: {$route['method']}";
        //         // echo $this->request->url();
        //         // $method = $route['method'];
        //         // $controller->$method();
        //     }
        // }
    }

    public function checkForControllerAndMethod(array $routes, callable $callback)
    {
        $path = $this->request->path; // ['test', 'test2', 'test3']
        $method = $this->request->method(); //

        foreach ($routes as $route) {
            $routePath = $route['path'];
            $routeMethod = $route['type'];

            $match = true;
            $matchedParams = [];
            // check if path and method are the same, and ignore params
            if (count($path) == count($routePath) && $method == $routeMethod) {
                foreach ($path as $key => $value) {
                    if ($value != $routePath[$key]) {
                        if (strpos($routePath[$key], '{') !== false) {
                            $matchedParams[] = $value;
                        } else {
                            $match = false;
                        }
                    }
                }
            } else {
                $match = false;
            }
            if ($match) {

                $callback($route, $matchedParams);

                break;
            }
        }
    }
}

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

        foreach ($routes as $route) {
            if (count($route['path']) != count($this->request->path)) continue;

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
                // echo 'matched';
                $controller = new $route['controller']();

                $paramsValues = [];
                foreach ($params as $param) {
                    $paramsValues[] = $this->request->path[$param['index']];
                }

                $method = $route['method'];
                $response = $controller->$method(...$paramsValues);
                if (is_string($response)) {
                    echo $response;
                } else if (is_array($response)) {
                    echo json($response);
                } else if (is_object($response)) {
                    echo $response->render();
                }
                return;
            }
        }

        echo abort(404);
    }
}

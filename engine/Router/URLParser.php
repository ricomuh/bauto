<?php

namespace Engine\Router;

trait URLParser
{
    public function sanitize($uri)
    {
        $uri = rtrim($uri, '/');
        $uri = filter_var($uri, FILTER_SANITIZE_URL);
        $uri = explode('/', $uri);

        return '/' . implode('/', $uri);
    }

    public function parsePath($uri)
    {
        $uri = explode('/', $uri);

        return $uri;
    }

    public function parseParams($uri)
    {
        $uri = explode('/', $uri);
        $params = [];

        foreach ($uri as $key => $value) {
            if (strpos($value, '{') !== false) {
                $params[] = str_replace(['{', '}'], '', $value);
            }
        }

        return $params;
    }
}

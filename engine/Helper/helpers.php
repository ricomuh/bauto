<?php

if (!function_exists('str')) {
    /**
     * Create a new stringable object from the given string.
     * 
     * @param string $string
     * @return \Engine\Helper\Stringable
     */
    function str($string = '')
    {
        return new \Engine\Helper\Stringable($string);
    }
}

if (!function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     * 
     * @param mixed ...$args
     * @return void
     */
    function dd(...$args)
    {
        foreach ($args as $arg) {
            var_dump($arg);
        }
        die();
    }
}

if (!function_exists('request')) {
    /**
     * Get the request instance.
     * 
     * @return \Engine\Handler\Request
     */
    function request()
    {
        return new \Engine\Handler\Request();
    }
}

if (!function_exists('collect')) {
    /**
     * Create a new collection instance.
     * 
     * @param array $items
     * @return \Engine\Helper\Collection
     */
    function collect($items = [])
    {
        return new \Engine\Helper\Collection($items);
    }
}

if (!function_exists('view')) {
    /**
     * Create a new view response instance.
     * 
     * @param string $view
     * @param array $data
     * @return ViewResponse
     */
    function view($view, $data = [])
    {
        return new Engine\Handler\Response\ViewResponse($view, $data);
    }
}

if (!function_exists('json')) {
    /**
     * Create a new json response instance.
     * 
     * @param array $data
     * @return JsonResponse
     */
    function json($data = [])
    {
        return new Engine\Handler\Response\JsonResponse($data);
    }
}

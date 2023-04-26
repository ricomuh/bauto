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
            echo view('framework/dd', ['arg' => $arg]);
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
    function json($data = [], $status = 200)
    {
        return new Engine\Handler\Response\JsonResponse($data, $status);
    }
}

if (!function_exists('redirect')) {
    /**
     * Create a new redirect response instance.
     * 
     * @param string $url
     * @return RedirectResponse
     */
    function redirect($url = '')
    {
        return new Engine\Handler\Response\RedirectResponse($url);
    }
}

if (!function_exists('abort')) {
    /**
     * Create a new abort response instance.
     * 
     * @param int $code
     * @return AbortResponse
     */
    function abort($code = 404, $message = null)
    {
        return new Engine\Handler\Response\AbortResponse($code, $message);
    }
}

if (!function_exists('url')) {
    /**
     * Create a relative url.
     * 
     * @param string $path
     * @return string
     */
    function url($path = '')
    {
        return request()->baseURL() . $path;
    }
}

if (!function_exists('route')) {
    /**
     * Create a relative url to the given route.
     * 
     * @param string $route
     * @param array $params
     * @return string
     */
    function route($route, $params = [])
    {
        $url = url($route);

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }
}

if (!function_exists('google_fonts')) {
    /**
     * Create a new google fonts instance.
     * 
     * @param array $fonts
     * @return GoogleFonts
     */
    function google_fonts($fonts = [])
    {
        return new Engine\Helper\GoogleFonts($fonts);
    }
}

if (!function_exists('asset')) {
    /**
     * Create a relative url to the public folder.
     * 
     * @param string $path
     * @return string
     */
    function asset($path = '')
    {
        return url($path);
    }
}

if (!function_exists('env')) {
    /**
     * Get the value of an environment variable.
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = $_ENV[$key] ?? null;

        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if (strlen($value) > 1 && str_starts_with($value, '"') && str_ends_with($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

if (!function_exists('cache')) {
    /**
     * Create a new cache instance.
     * 
     * @param string $key
     * @param mixed $value
     * @param int $minutes
     * @return Cache
     */
    function cache()
    {
        return new Engine\Helper\Cache();
    }
}

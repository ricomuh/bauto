<?php

namespace Engine\Handler;

use Engine\Router\URLParser;

class Request
{
    use URLParser;

    protected $url;
    protected $method;
    public $path = [];
    protected $baseURL = '';

    protected $get = [];
    protected $post = [];

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;

        $this->url = $this->sanitize($this->get('url') ?? '/');
        $this->path = $this->parsePath($this->url);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->baseURL = $this->getBaseURL();

        unset($this->get['url']);

        foreach ($this->post as $key => $value) {
            $this->$key = $value;
        }
    }

    public function accept($type)
    {
        $accept = $_SERVER['HTTP_ACCEPT'] ?? null;

        if ($accept) {
            $accept = explode(',', $accept);
            $accept = array_map('trim', $accept);

            return in_array($type, $accept);
        }

        return false;
    }

    public function acceptJSON()
    {
        return $this->accept('application/json');
    }

    public function getBaseURL()
    {
        $baseURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
        $baseURL = str_replace('index.php', '', $baseURL);

        return $baseURL;
    }

    public function url()
    {
        return $this->url;
    }

    public function method()
    {
        return $this->method;
    }

    public function path()
    {
        return $this->path;
    }

    public function baseURL()
    {
        return $this->baseURL;
    }

    public function get($key = null)
    {
        if ($key) {
            return $this->get[$key] ?? null;
        }

        return $this->get;
    }

    public function has($key)
    {
        return isset($this->get[$key]);
    }

    public function post($key = null)
    {
        if ($key) {
            return $this->post[$key] ?? null;
        }

        return $this->post;
    }
}

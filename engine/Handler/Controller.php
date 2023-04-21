<?php

namespace Engine\Handler;

use Engine\Handler\Request;
use Engine\Handler\Response\ViewResponse as View;

class Controller
{
    protected $request;
    protected $middleware = [];
    protected $prefix = '';
    protected $as = '';

    public function __construct()
    {
        $this->request = new Request;
    }

    public function middleware($middleware)
    {
        $this->middleware[] = $middleware;
    }

    public function prefix($prefix)
    {
        $this->prefix = $prefix;
    }

    public function as($as)
    {
        $this->as = $as;
    }

    public function getControllerUrl()
    {
        $url = $this->prefix . '/' . $this->as;
        $url = str_replace('//', '/', $url);
        return $url;
    }

    /**
     * @param string $view
     * @param array $data
     * @return View
     */
    public function view($view, $data = [])
    {
        return new View($view, $data);
    }

    /**
     * @param string $url
     * @return void
     */
    public function redirect($url)
    {
    }

    /**
     * @param array $data
     * @param int $status
     * @return Json
     */
    public function json($data, $status = 200)
    {
    }
}

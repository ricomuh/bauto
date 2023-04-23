<?php

namespace Engine\Handler\Response;

class RedirectResponse
{

    /**
     * @var string
     */
    public $url;

    /**
     * RedirectResponse constructor.
     * 
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Redirect to route
     * 
     * @param string $route
     * @param array $params
     */
    public function route($route, $params = [])
    {
        $this->url = route($route, $params);
    }

    /**
     * Redirect to url
     * 
     * @param string $url
     */
    public function render()
    {
        header('Location: ' . $this->url);
        exit;
    }
}

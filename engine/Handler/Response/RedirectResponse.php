<?php

namespace Engine\Handler\Response;

class RedirectResponse
{

    protected $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function route($route, $params = [])
    {
        $this->url = route($route, $params);
    }

    public function render()
    {
        header('Location: ' . $this->url);
        exit;
    }

    public function __toString()
    {
        return $this->render();
    }
}

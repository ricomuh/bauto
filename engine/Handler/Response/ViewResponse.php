<?php

namespace Engine\Handler\Response;

class ViewResponse
{
    protected $viewDir = '../app/Views/';

    protected $view;
    protected $data;

    public function __construct($view, $data = [])
    {
        $this->view = $view;
        $this->data = $data;
    }

    public function render()
    {
        $view = $this->viewDir . $this->view . '.php';

        if (!file_exists($view)) {
            throw new \Exception('View not found');
        }

        ob_start();
        extract($this->data);
        require $view;
        $content = ob_get_clean();

        return $content;
    }

    public function __toString()
    {
        return $this->render();
    }
}

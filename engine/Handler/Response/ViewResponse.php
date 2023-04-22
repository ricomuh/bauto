<?php

namespace Engine\Handler\Response;

class ViewResponse
{
    protected $viewDir = '../app/Views/';

    protected $view;
    protected $data;
    protected $content;
    protected $sections = [];
    protected $currentSection;

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
        $this->content = ob_get_clean();

        return $this->content;
    }

    public function __toString()
    {
        return $this->render();
    }

    public function setSections($sections)
    {
        $this->sections = $sections;
    }

    public function section($name, $content = null)
    {
        if (is_null($content)) {
            ob_start();
            $this->currentSection = $name;
        } else {
            $this->sections[$name] = $content;
        }
    }

    public function endSection()
    {
        $this->sections[$this->currentSection] = ob_get_clean();
    }

    public function hasSection($name)
    {
        return isset($this->sections[$name]);
    }

    public function push($name, $content = null)
    {
        if (is_null($content)) {
            ob_start();
            $this->currentSection = $name;
        } else {
            $this->sections[$name] .= $content;
        }
    }

    public function endPush()
    {
        if (!$this->hasSection($this->currentSection)) {
            $this->sections[$this->currentSection] = '';
        }
        $this->sections[$this->currentSection] .= ob_get_clean();
    }

    public function extend($view)
    {
        $view = new ViewResponse($view);
        $view->setSections($this->sections);

        return $view;
    }

    public function yield($name, $default = '')
    {
        echo $this->sections[$name] ?? $default;
    }
}

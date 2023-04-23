<?php

namespace Engine\Handler\Response;

class ViewResponse
{
    // This is the path to the views folder
    protected $viewDir = '../app/Views/';

    protected $view;
    protected $data;
    protected $content;
    protected $sections = [];
    protected $currentSection;
    protected $extends;

    /**
     * ViewResponse constructor.
     * 
     * @param string $view
     * @param array $data
     */
    public function __construct($view, $data = [])
    {
        $this->view = $view;
        $this->data = $data;
    }

    /**
     * Render view
     * 
     * @return string
     * @throws \Exception
     */
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

        if ($this->extends) {
            $this->extends->setSections($this->sections);
            echo $this->extends;
        }

        return $this->content;
    }

    /**
     * Convert to string
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Set sections
     * 
     * @param array $sections
     */
    public function setSections($sections)
    {
        $this->sections = $sections;
    }

    /**
     * Set sections, used for extending views
     * If the content is null, start buffering
     * 
     * @param string $name
     * @param string $content
     */
    public function section($name, $content = null)
    {
        if (is_null($content)) {
            ob_start();
            $this->currentSection = $name;
        } else {
            $this->sections[$name] = $content;
        }
    }

    /**
     * End the section buffering, and set the section
     * 
     * @return void
     */
    public function endSection()
    {
        $this->sections[$this->currentSection] = ob_get_clean();
    }

    /**
     * Check if a section exists
     * 
     * @param string $name
     * @return bool
     */
    public function hasSection($name)
    {
        return isset($this->sections[$name]);
    }

    /**
     * Start buffering a section and append to it
     * 
     * @param string $name
     * @param string $content
     */
    public function push($name, $content = null)
    {
        if (is_null($content)) {
            ob_start();
            $this->currentSection = $name;
        } else {
            $this->sections[$name] .= $content;
        }
    }

    /**
     * End the section buffering, and append to the section
     * 
     * @return void
     */
    public function endPush()
    {
        if (!$this->hasSection($this->currentSection)) {
            $this->sections[$this->currentSection] = '';
        }
        $this->sections[$this->currentSection] .= ob_get_clean();
    }

    /**
     * Extend a view
     * 
     * @param string $view
     * @return void
     */
    public function extend($view)
    {
        $extends = new ViewResponse($view);

        $this->extends = $extends;
    }


    /**
     * Include a view
     * 
     * @param string $view
     * @param array $data
     * @return ViewResponse
     */
    public function include($view, $data = [])
    {
        return view($view, $data);
    }

    /**
     * Echo a section
     * 
     * @param string $name
     * @param string $default
     */
    public function yield($name, $default = '')
    {
        echo $this->sections[$name] ?? $default;
    }
}

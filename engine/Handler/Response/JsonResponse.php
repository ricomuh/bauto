<?php

namespace Engine\Handler\Response;

class JsonResponse
{
    protected $data;
    protected $status;

    public function __construct($data = [], $status = 200)
    {
        $this->data = $data;
        $this->status = $status;
    }

    public function render()
    {
        header('Content-Type: application/json');
        http_response_code($this->status);
        return json_encode($this->data);
    }

    public function __toString()
    {
        return $this->render();
    }
}

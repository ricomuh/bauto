<?php

namespace Engine\Handler\Response;

use Engine\Helper\Collection;

class JsonResponse
{
    protected $data;
    protected $status;

    /**
     * JsonResponse constructor.
     * 
     * @param array $data
     * @param int $status
     */
    public function __construct($data = [], $status = 200)
    {
        $this->data = $data;
        $this->status = $status;
    }

    /**
     * Render json response
     * 
     * @return string
     */
    public function render()
    {
        header('Content-Type: application/json');
        http_response_code($this->status);
        if ($this->data instanceof Collection) return (string) $this->data;
        return json_encode($this->data);
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
}

<?php

namespace Engine\Handler\Response;

class AbortResponse
{
    protected $code;
    protected $message;

    protected $view = 'error';

    /**
     * AbortResponse constructor.
     * 
     * @param int $code
     * @param null $message
     */
    public function __construct($code = 404, $message = null)
    {
        $this->code = $code;
        $this->message = $message ?? $this->getDefaultMessage($code);
    }

    /**
     * Get default message from code
     * 
     * @param int $code
     * @return string
     */
    public function getDefaultMessage(int $code)
    {
        $messages = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            402 => 'Payment required',
            403 => 'Access denied',
            404 => 'Page not found',
            500 => 'Internal server error',
            501 => 'Not implemented',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
            504 => 'Gateway timeout',
            505 => 'HTTP version not supported',
        ];

        return $messages[$code] ?? 'Unknown error';
    }

    /**
     * Render abort response
     * 
     * @return string
     */
    public function render()
    {
        http_response_code($this->code);

        if (request()->acceptJson()) {
            return json([
                'code' => $this->code,
                'message' => $this->message,
            ], $this->code);
        }

        return view($this->view, [
            'code' => $this->code,
            'message' => $this->message,
        ]);
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

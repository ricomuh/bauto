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

    /**
     * Request constructor
     * 
     * @return void
     */
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

    /**
     * Check if the request accepts a specific type
     * 
     * @param string $type
     * @return bool
     */
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

    /**
     * Check if the request accepts HTML
     * 
     * @return bool
     */
    public function acceptHTML()
    {
        return $this->accept('text/html');
    }

    /**
     * Check if the request accepts JSON
     * 
     * @return bool
     */
    public function acceptJSON()
    {
        return $this->accept('application/json');
    }

    /**
     * Check if the request accepts XML
     * 
     * @return bool
     */
    public function acceptXML()
    {
        return $this->accept('application/xml');
    }

    /**
     * Check if the request accepts plain text
     * 
     * @return bool
     */
    public function acceptText()
    {
        return $this->accept('text/plain');
    }

    /**
     * Check if the request accepts a specific language
     * 
     * @param string $language
     * @return bool
     */
    public function acceptLanguage($language)
    {
        $acceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? null;

        if ($acceptLanguage) {
            $acceptLanguage = explode(',', $acceptLanguage);
            $acceptLanguage = array_map('trim', $acceptLanguage);

            return in_array($language, $acceptLanguage);
        }

        return false;
    }

    /**
     * Check if the request accepts a specific encoding
     * 
     * @param string $encoding
     * @return bool
     */
    public function acceptEncoding($encoding)
    {
        $acceptEncoding = $_SERVER['HTTP_ACCEPT_ENCODING'] ?? null;

        if ($acceptEncoding) {
            $acceptEncoding = explode(',', $acceptEncoding);
            $acceptEncoding = array_map('trim', $acceptEncoding);

            return in_array($encoding, $acceptEncoding);
        }

        return false;
    }

    /**
     * Check if the request accepts a specific charset
     * 
     * @param string $charset
     * @return bool
     */
    public function acceptCharset($charset)
    {
        $acceptCharset = $_SERVER['HTTP_ACCEPT_CHARSET'] ?? null;

        if ($acceptCharset) {
            $acceptCharset = explode(',', $acceptCharset);
            $acceptCharset = array_map('trim', $acceptCharset);

            return in_array($charset, $acceptCharset);
        }

        return false;
    }

    /**
     * Check if the request is AJAX
     * 
     * @return bool
     */
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * Get the request's base URL
     * 
     * @return string
     */
    public function getBaseURL()
    {
        $baseURL = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
        $baseURL = str_replace('index.php', '', $baseURL);

        return $baseURL;
    }

    /**
     * Get the request's URL
     * 
     * @return string
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * Get the request's method
     * 
     * @return string
     */
    public function method()
    {
        return $this->method;
    }

    /**
     * Get the request's path
     * 
     * @return array
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * Get the request's base URL
     * 
     * @return string
     */
    public function baseURL()
    {
        return $this->baseURL;
    }

    /**
     * Get the request's GET parameters
     * 
     * @param string $key
     * @return mixed
     */
    public function get($key = null)
    {
        if ($key) {
            return $this->get[$key] ?? null;
        }

        return $this->get;
    }

    /**
     * Check if the request has a GET parameter
     * 
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->get[$key]);
    }

    /**
     * Get the request's POST parameters
     * 
     * @param string $key
     * @return mixed
     */
    public function post($key = null)
    {
        if ($key) {
            return $this->post[$key] ?? null;
        }

        return $this->post;
    }

    /**
     * Get the request's POST parameters
     * 
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->$key ?? null;
    }
}

<?php

namespace Engine\Handler;

trait ValidationRules
{

    /**
     * The required rule of the validation
     * 
     * @param string $key
     * @return void
     */
    public function required($key)
    {
        if (!isset($this->post[$key]) || empty($this->post[$key])) {
            $this->errors[$key][] = "The {$key} field is required";
        }
    }

    /**
     * The string rule of the validation
     * 
     * @param string $key
     * @return void
     */
    public function string($key)
    {
        if (!is_string($this->post[$key])) {
            $this->errors[$key][] = "The {$key} field must be a string";
        }
    }

    /**
     * The integer rule of the validation
     * 
     * @param string $key
     * @return void
     */
    public function integer($key)
    {
        if (!is_int($this->post[$key])) {
            $this->errors[$key][] = "The {$key} field must be an integer";
        }
    }

    /**
     * The max rule of the validation
     * 
     * @param string $key
     * @param int $value
     * @return void
     */
    public function max($key, $value)
    {
        if (strlen($this->post[$key]) > $value) {
            $this->errors[$key][] = "The {$key} field must be less than {$value} characters";
        }
    }

    /**
     * The min rule of the validation
     * 
     * @param string $key
     * @param int $value
     * @return void
     */
    public function min($key, $value)
    {
        if (strlen($this->post[$key]) < $value) {
            $this->errors[$key][] = "The {$key} field must be at least {$value} characters";
        }
    }

    /**
     * The email rule of the validation
     * 
     * @param string $key
     * @return void
     */
    public function email($key)
    {
        if (!filter_var($this->post[$key], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$key][] = "The {$key} field must be a valid email address";
        }
    }
}

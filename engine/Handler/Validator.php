<?php

namespace Engine\Handler;

class Validator
{
    use ValidationRules;

    /**
     * The errors of the validation
     * 
     * @var array
     */
    public $errors = [];

    /**
     * The rules of the validation
     * 
     * @var array
     */
    public $rules = [];

    /**
     * The request's POST parameters
     * 
     * @var array
     */
    protected $post = [];

    /**
     * Validator constructor
     * 
     * @param array $post
     * @return void
     */
    public function __construct(array $post, array $rules)
    {
        /**
         * new Validator([
         *   'title' => ['required', 'string', 'max:255'],
         *   'content' => ['required', 'string']
         * ]);
         */
        $this->post = $post;
        $this->rules = $rules;
    }

    /**
     * Validate the request
     * 
     * @return bool
     */
    public function validate()
    {
        foreach ($this->rules as $key => $rules) {
            foreach ($rules as $rule) {
                $this->checkRule($key, $rule);
            }
        }

        return empty($this->errors);
    }

    /**
     * Check a rule
     * 
     * @param string $key
     * @param string $rule
     * @return void
     */
    protected function checkRule(string $key, string $rule)
    {
        $rule = explode(':', $rule);
        $ruleName = $rule[0];
        $ruleValue = $rule[1] ?? null;

        if (method_exists($this, $ruleName)) {
            // $this->$ruleName($key, $ruleValue);
            $this->$ruleName($key, $ruleValue);
        }
    }

    /**
     * Add an error
     * 
     * @param string $key
     * @param string $message
     * @return void
     */
    protected function addError(string $key, string $message)
    {
        $this->errors[$key][] = $message;
    }

    public function fails()
    {
        return !empty($this->errors);
    }

    /**
     * Get the errors
     * 
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }
}

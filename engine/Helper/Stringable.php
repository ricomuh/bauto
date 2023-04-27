<?php

namespace Engine\Helper;

class Stringable
{

    protected $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->string;
    }

    /**
     * Example: str('Hello World')->camelCase(); // helloWorld
     * 
     * @param string $string
     * @return \Engine\Helper\Stringable
     */
    public function camelCase()
    {
        $this->string = Str::camelCase($this->string);

        return $this;
    }

    /**
     * Example: str('Hello World')->kebabCase(); // hello-world
     * 
     * @param string $string
     * @return \Engine\Helper\Stringable
     */
    public function snakeCase()
    {
        $this->string = Str::snakeCase($this->string);

        return $this;
    }

    /**
     * Example: str('Hello World')->studlyCase(); // HelloWorld
     * 
     * @param string $string
     * @return \Engine\Helper\Stringable
     */
    public function studlyCase()
    {
        $this->string = Str::studlyCase($this->string);

        return $this;
    }

    /**
     * Example: str('Hello World')->startsWith('Hello'); // true
     * 
     * @param string $string
     * @return bool
     */
    public function startsWith($needle)
    {
        return Str::startsWith($this->string, $needle);
    }

    /**
     * Example: str('Flight')->plural(); // Flights
     * 
     * @param string $string
     * @return \Engine\Helper\Stringable
     */
    public function plural()
    {
        $this->string = Str::plural($this->string);

        return $this;
    }

    /**
     * Example: str('Flights')->singular(); // Flight
     * 
     * @param string $string
     * @return \Engine\Helper\Stringable
     */
    public function singular()
    {
        $this->string = Str::singular($this->string);

        return $this;
    }

    /**
     * Example: str()->random(16); // 16 random characters
     * 
     * @param string $string
     * @return \Engine\Helper\Stringable
     */
    public function random($length = 16)
    {
        $this->string = Str::random($length);

        return $this;
    }

    public function length()
    {
        return Str::length($this->string);
    }

    public function limit($limit = 100, $end = '...')
    {
        $this->string = Str::limit($this->string, $limit, $end);

        return $this;
    }

    public function slug($separator = '-')
    {
        $this->string = Str::slug($this->string, $separator);

        return $this;
    }

    public function title()
    {
        $this->string = Str::title($this->string);

        return $this;
    }

    public function lower()
    {
        $this->string = Str::lower($this->string);

        return $this;
    }

    public function upper()
    {
        $this->string = Str::upper($this->string);

        return $this;
    }

    public function wordsLimit($limit = 100, $end = '...')
    {
        $this->string = Str::wordsLimit($this->string, $limit, $end);

        return $this;
    }

    public function contains($needle)
    {
        return Str::contains($this->string, $needle);
    }
}

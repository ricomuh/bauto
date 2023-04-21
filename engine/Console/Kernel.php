<?php

namespace Engine\Console;

class Kernel
{
    protected $command = '';
    protected $parsedParams = [];
    protected $params = [];
    protected $flags = [];

    protected $stubsDir = __DIR__ . '../stubs/';

    protected $commands = [];

    public static function run($argv)
    {
        $console = new Console();
        $console->parse($argv);
        $console->execute();
    }

    /**
     * Parse the command line arguments
     * 
     * @param array $argv
     * @return void
     */
    public function parse($argv)
    {
        $this->command = $argv[1];
        $this->parsedParams = array_slice($argv, 2);

        foreach ($this->parsedParams as $param) {
            if (strpos($param, '--') === 0) {
                $this->flags[] = substr($param, 2);
            } else {
                $this->params[] = $param;
            }
        }
    }

    /**
     * Register a new command
     * 
     * @param string $command
     * @param callable $callback
     * @return void
     */
    public function register(string $command, $callback)
    {
        if ($this->command === $command) {
            $callback($this->params, $this->flags);
        }
    }

    /**
     * Execute the command
     * 
     * @return void
     */
    public function execute()
    {
        if (!empty($this->command) && isset($this->commands[$this->command])) {
            $method = $this->commands[$this->command];
            $this->$method();
        }
    }

    /**
     * Copy a file from the stubs directory
     * 
     * @return void
     */
    public function copyFileFromStub($stub, $destination, $replace = [])
    {
        $file = file_get_contents($stub);
        foreach ($replace as $key => $value) {
            $file = str_replace($key, $value, $file);
        }
        file_put_contents($destination, $file);
    }

    public function runCommand(string $command)
    {
        // run console command

        system($command);
    }
}

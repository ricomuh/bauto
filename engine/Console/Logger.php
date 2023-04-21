<?php

namespace Engine\Console;

class Logger
{

    public $colors = [
        'primary' => "\033[0;36m",
        'secondary' => "\033[0;35m",
        'success' => "\033[0;32m",
        'warning' => "\033[0;33m",
        'danger' => "\033[0;31m",
        'info' => "\033[0;37m",
        'light' => "\033[0;37m",
    ];

    public $close = "\033[0m";

    public static function color(string $color, string $message)
    {
        $colors = [
            'primary' => "\033[0;36m",
            'secondary' => "\033[0;35m",
            'success' => "\033[0;32m",
            'warning' => "\033[0;33m",
            'danger' => "\033[0;31m",
            'info' => "\033[0;37m",
            'light' => "\033[0;37m",
        ];

        $close = "\033[0m";

        return $colors[$color] . $message . $close;
    }

    public static function log(string $message, bool $newLine = true)
    {
        echo self::color('info', $message);
        if ($newLine) echo PHP_EOL;
    }

    public static function header(string $message, bool $newLine = true)
    {
        echo self::color('primary', $message);
        if ($newLine) echo PHP_EOL;
    }

    public static function nl()
    {
        echo PHP_EOL;
    }

    public static function indent(string $message, bool $newLine = true)
    {
        echo '    ' . self::color('info', $message);
        if ($newLine) echo PHP_EOL;
    }

    public static function details(array $array, string $separator = '-')
    {
        $max = 0;

        foreach ($array as $key => $value) {
            if (strlen($key) > $max) {
                $max = strlen($key);
            }
        }

        foreach ($array as $key => $value) {
            $key = str_pad($key, $max, ' ', STR_PAD_RIGHT);
            echo self::color('info', '    ' . $key . " $separator ") . $value . PHP_EOL;
        }
    }

    public static function ask(string $message)
    {
        echo self::color('secondary', $message);

        return trim(readline());
    }

    public static function confirm(string $message)
    {
        echo self::color('secondary', $message . ' [y/n] ');

        return strtolower(trim(readline())) === 'y';
    }

    public static function params(string $message)
    {
        $params = [];
        $flags = [];

        echo self::color('secondary', $message);
        $input = explode(' ', trim(readline()));

        foreach ($input as $param) {
            if (strpos($param, '--') === 0) {
                $flags[] = substr($param, 2);
            } else {
                $params[] = $param;
            }
        }

        return compact('params', 'flags');
    }

    public static function table(array $array, bool $header = true, bool $numbers = true)
    {
        $table = '';

        if ($numbers) {
            for ($i = 0; $i < count($array); $i++) {
                $array[$i] = array_merge(['no' => $i + 1], $array[$i]);
            }
        }

        if ($header) {
            $keys = array_keys($array[0]);

            $header = [];
            foreach ($keys as $key) {
                $header[$key] = $key;
            }

            $array = array_merge([$header], $array);
        }

        $max = [];

        foreach ($array as $row) {
            foreach ($row as $key => $value) {
                if (!isset($max[$key])) {
                    $max[$key] = 0;
                }

                if (strlen($value) > $max[$key]) {
                    $max[$key] = strlen($value);
                }
            }
        }

        foreach ($max as $key => $value) {
            // $table .= "\033[0;37m" . '+--' . str_repeat('-', $max[$key]) . "\033[0m";
            $table .= self::color('info', '+--' . str_repeat('-', $max[$key]));
        }
        $table .= self::color('info', '+');
        $table .= PHP_EOL;

        $i = 0;

        foreach ($array as $row) {
            $i++;

            foreach ($row as $key => $value) {
                $value = str_pad($value, $max[$key], ' ', STR_PAD_RIGHT);

                if (gettype($value) === 'boolean') {
                    $value = $value ? 'true' : 'false';
                }

                if ($i === 1 && $header) {
                    // $table .= "\033[0;37m" . '| ' . $value . " |\033[0m";
                    // make it bold and blue
                    // $table .= "\033[0;37m" . '| ' . "\033[0;34m" . "\033[1m" . $value . "\033[0m" . " \033[0m";
                    $table .= self::color('info', '| ') . self::color('primary', $value) . self::color('info', ' ');
                } else {
                    // $table .= "\033[0;37m" . '| ' . $value . " \033[0m";
                    $table .= self::color('info', '| ') . $value . self::color('info', ' ');
                }
            }

            // $table .= "\033[0;37m" . '|' . "\033[0m";
            $table .= self::color('info', '|');

            $table .= PHP_EOL;

            foreach ($max as $key => $value) {
                // $table .= "\033[0;37m" . '+--' . str_repeat('-', $max[$key]) . "\033[0m";
                $table .= self::color('info', '+--' . str_repeat('-', $max[$key]));
            }
            // $table .= "\033[0;37m" . '+' . "\033[0m";
            $table .= self::color('info', '+');

            $table .= PHP_EOL;
        }

        echo $table;
    }

    public static function error(string $message, bool $newLine = true)
    {
        echo self::color('danger', $message);
        if ($newLine) echo PHP_EOL;
    }

    public static function warning(string $message, bool $newLine = true)
    {
        echo self::color('warning', $message);
        if ($newLine) echo PHP_EOL;
    }

    public static function success(string $message, bool $newLine = true)
    {
        echo self::color('success', $message);
        if ($newLine) echo PHP_EOL;
    }
}

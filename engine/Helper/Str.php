<?php

namespace Engine\Helper;

class Str
{

    public static function camelCase($string)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $string))));
    }

    public static function snakeCase($string)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }

    public static function studlyCase($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    public static function random($length = 16)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);

        return (substr($haystack, 0, $length) === $needle);
    }

    public static function plural(string $string)
    {
        $plural = [
            '(quiz)$'               => "$1zes",
            '^(ox)$'                => "$1en",
            '([m|l])ouse$'          => "$1ice",
            '(matr|vert|ind)ix|ex$' => "$1ices",
            '(x|ch|ss|sh)$'         => "$1es",
            '([^aeiouy]|qu)y$'      => "$1ies",
            '(hive)$'               => "$1s",
            '(?:([^f])fe|([lr])f)$' => "$1$2ves",
            '(shea|lea|loa|thie)f$' => "$1ves",
            'sis$'                  => "ses",
            '([ti])um$'             => "$1a",
            '(tomat|potat|ech|her|vet)o$' => "$1oes",
            '(bu)s$'                => "$1ses",
            '(alias)$'              => "$1es",
            '(octop)us$'            => "$1i",
            '(ax|test)is$'          => "$1es",
            '(us)$'                 => "$1es",
            '([^s]+)$'              => "$1s"
        ];

        foreach ($plural as $rule => $replacement) {
            if (preg_match("/$rule$/i", $string)) {
                return preg_replace("/$rule$/i", $replacement, $string);
            }
        }

        return $string;
    }

    public static function singular(string $string)
    {
        $singular = [
            '(quiz)zes$'             => "$1",
            '(matr)ices$'            => "$1ix",
            '(vert|ind)ices$'        => "$1ex",
            '^(ox)en$'               => "$1",
            '(alias)es$'             => "$1",
            '(octop|vir)i$'          => "$1us",
            '(cris|ax|test)es$'      => "$1is",
            '(shoe)s$'               => "$1",
            '(o)es$'                 => "$1",
            '(bus)es$'               => "$1",
            '([m|l])ice$'            => "$1ouse",
            '(x|ch|ss|sh)es$'        => "$1",
            '(m)ovies$'              => "$1ovie",
            '(s)eries$'              => "$1eries",
            '([^aeiouy]|qu)ies$'     => "$1y",
            '([lr])ves$'             => "$1f",
            '(tive)s$'               => "$1",
            '(hive)s$'               => "$1",
            '([^f])ves$'             => "$1fe",
            '(^analy)ses$'           => "$1sis",
            '(analy|ba|diagno|parenthe|progno|synop|the)ses$' => "$1sis",
            '([ti])a$'               => "$1um",
            '(n)ews$'                => "$1ews",
            '(h|bl)ouses$'           => "$1ouse",
            '(corpse)s$'             => "$1",
            '(us)es$'                => "$1",
            's$'                     => ""
        ];

        foreach ($singular as $rule => $replacement) {
            if (preg_match("/$rule$/i", $string)) {
                return preg_replace("/$rule$/i", $replacement, $string);
            }
        }

        return $string;
    }

    public static function slug(string $string, string $separator = '-')
    {

        $string = preg_replace('/[^\p{L}\p{Nd}]+/u', $separator, $string);

        $string = trim($string, $separator);

        return strtolower($string);
    }

    public static function limit(string $string, int $limit = 100, string $end = '...')
    {
        if (mb_strwidth($string, 'UTF-8') <= $limit) {
            return $string;
        }

        return rtrim(mb_strimwidth($string, 0, $limit, '', 'UTF-8')) . $end;
    }

    public static function wordsLimit(string $string, int $limit = 100, string $end = '...')
    {
        $words = explode(' ', $string);

        if (count($words) <= $limit) {
            return $string;
        }

        return implode(' ', array_slice($words, 0, $limit)) . $end;
    }

    public static function title(string $string)
    {
        return mb_convert_case($string, MB_CASE_TITLE, 'UTF-8');
    }

    public static function upper(string $string)
    {
        return mb_strtoupper($string, 'UTF-8');
    }

    public static function lower(string $string)
    {
        return mb_strtolower($string, 'UTF-8');
    }

    public static function length(string $string)
    {
        return mb_strlen($string, 'UTF-8');
    }

    public static function substr(string $string, int $start, int $length = null)
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    public static function replace(string $string, $search, $replace)
    {
        return str_replace($search, $replace, $string);
    }

    public static function replaceArray(string $string, array $search, $replace)
    {
        foreach ($search as $value) {
            $string = str_replace($value, $replace, $string);
        }

        return $string;
    }

    public static function replaceFirst(string $string, $search, $replace)
    {
        if ($search == '') {
            return $string;
        }

        $position = strpos($string, $search);

        if ($position !== false) {
            return substr_replace($string, $replace, $position, strlen($search));
        }

        return $string;
    }

    public static function replaceLast(string $string, $search, $replace)
    {
        $position = strrpos($string, $search);

        if ($position !== false) {
            return substr_replace($string, $replace, $position, strlen($search));
        }

        return $string;
    }

    public static function studly(string $string)
    {
        $string = ucwords(str_replace(['-', '_'], ' ', $string));

        return str_replace(' ', '', $string);
    }

    public static function camel(string $string)
    {
        return lcfirst(static::studly($string));
    }

    public static function kebab(string $string)
    {
        return static::slug($string, '-');
    }

    public static function snake(string $string, string $delimiter = '_')
    {
        $replace = '$1' . $delimiter . '$2';

        return ctype_lower($string) ? $string : strtolower(preg_replace('/(.)([A-Z])/', $replace, $string));
    }

    public static function contains(string $haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }
}

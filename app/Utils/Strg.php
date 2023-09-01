<?php

namespace App\Utils;

class Strg
{
    public static function lower($str): string
    {
        return self::sanitize(strtolower($str));
    }

    /**
     * Convert all words of string to upper case and the rest to lower case
     *
     * @param [string] $str
     * @return string
     */
    public static function upperWordsFirst($str): string
    {
        return self::sanitize(ucwords(strtolower($str)));
    }

    /**
     * Sanitize string
     *
     * @param [string] $str
     * @return string
     */
    public static function sanitize($str): string
    {
        return trim($str);
    }
}

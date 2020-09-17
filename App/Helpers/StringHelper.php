<?php


namespace App\Helpers;


class StringHelper
{
    public static function toCamelCase($string)
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);

        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    public static function removeExtension($string)
    {
        return substr($string, 0, strrpos($string, "."));
    }
}

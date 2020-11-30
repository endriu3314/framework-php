<?php

namespace App\Core\Helpers;

class StringHelper
{
    /**
     * Change a string to camelCase
     *
     * @param string $string
     *
     * @return string
     */
    public static function toCamelCase(string $string): string
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);

        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    /**
     * Remove extension from a filename
     *
     * @param string $string
     *
     * @return string
     * @example removeExtension('test.php') => test
     */
    public static function removeExtension(string $string): string
    {
        return substr($string, 0, strrpos($string, '.'));
    }

    /**
     * Remove last occurrence of a string in a string
     *
     * @param string $string
     * @param string $toRemove
     *
     * @return string
     * @example removeLastOccurrence('test..', '.') => test.
     */
    public static function removeLastOccurrence(string $string, string $toRemove): string
    {
        return substr_replace($string, '', strrpos($string, $toRemove), strlen($toRemove));
    }

    /**
     * Split a file path to get just the filename
     *
     * @param string $path
     * @param string $extension
     *
     * @return string
     */
    public static function getFileNameFromPath(string $path, string $extension = ''): string
    {
        return basename($path, $extension);
    }
}

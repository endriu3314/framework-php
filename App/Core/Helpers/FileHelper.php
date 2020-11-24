<?php

namespace App\Core\Helpers;

class FileHelper
{
    /**
     * Get rid of dots and `.DS_Store` in a folder.
     *
     * @param string $path The relative path to directory to scan.
     *
     * @return array The array of files
     */
    public static function getFiles(string $path): array
    {
        $files = scandir($path);
        $result = [];

        foreach ($files as $key => $file) {
            if (!in_array($file, array('.', '..', '.DS_Store'))) {
                $result[] = $file;
            }
        }

        return $result;
    }
}

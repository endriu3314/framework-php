<?php

namespace App\Core\Helpers;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

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

        foreach ($files as $file) {
            if (is_dir($path . DIRECTORY_SEPARATOR . $file)) {
                continue;
            }
            if (!in_array($file, ['.', '..', '.DS_Store'])) {
                $result[] = $file;
            }
        }

        return $result;
    }

    /**
     * Get all files in folder and subfolder.
     *
     * @param string $path The relative path to directory to scan.
     *
     * @return array The array of files
     */
    public static function getFilesRecursive(string $path): array
    {
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        $result = [];

        foreach ($rii as $file) {
            if ($file->isDir()) {
                continue;
            }
            $result[] = $file->getPathName();
        }

        return $result;
    }
}

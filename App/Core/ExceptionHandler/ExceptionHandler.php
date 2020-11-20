<?php

namespace App\Core\ExceptionHandler;

/**
 * Class ExceptionHandler
 * Used to handle errors in development mode
 */
class ExceptionHandler
{
    /**
     * Get each line of a file in array
     *
     * @param string $filePath - Path to file on disk
     *
     * @return string[] - Each line is an index in array
     */
    public static function getFileContentArrayFromPath(string $filePath): array
    {
        $file = fopen($filePath, 'r');

        $fileArray = [''];

        while (!feof($file)) {
            $fileArray[] = fgets($file);
        }

        fclose($file);

        return $fileArray;
    }

    /**
     * Get file content inside a string
     *
     * @param string $filePath - Path to file on disk
     *
     * @return string - Content of file
     */
    public static function getFileContentStringFromPath(string $filePath): string
    {
        return file_get_contents($filePath);
    }

    /**
     * Print lines from array on page
     * Prints a number of lines before and after the Exception line
     *
     * @param array $fileContentArray - File of exception content
     * @param mixed $exception - Exception object/array
     * @param int $lines - Number of lines to print (before and after error line)
     * @param string $type - Type of exception (object/array)
     */
    public static function printFileLinesFromArray(array $fileContentArray, $exception, int $lines = 3, string $type = 'object')
    {
        $line = $type == 'object' ? $exception->getLine() : $exception['line'];
        $start = $line - $lines;
        $final = $line + $lines;
        $totalLines = count($fileContentArray);

        if ($start < 0) {
            echo 'There was an error, starting from line 0';
            $start = 0;
        }

        if ($final > $totalLines - 1) {
            echo 'There was an error, going till end of file'.'<br/><br/>';
            $final = $totalLines - 1;
        }

        for ($counter = $start; $counter <= $final; $counter++) {
            if ($counter < 10) {
                echo $counter.'  ';
            } else {
                echo $counter.' ';
            }

            $style = $counter == $line ? 'background-color: #FC8181' : 'background-color: none';
            echo '<a style="'.$style.'">'.$fileContentArray[$counter].'</a>';
        }
    }
}

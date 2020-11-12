<?php


namespace App\Core\ExceptionHandler;


class ExceptionHandler
{
    public static function getFileContentArrayFromPath($filePath)
    {
        $file = fopen($filePath, "r");

        $fileArray = [];

        while (!feof($file)) {
            $fileArray[] = fgets($file);
        }

        fclose($file);

        return $fileArray;
    }

    public static function printFileLinesFromArray($fileContentArray, $exception, $lines = 3)
    {
        $start = $exception->getLine() - $lines;
        $final = $exception->getLine() + $lines;
        $totalLines = count($fileContentArray);

        if ($start < 0) {
            echo "There was an error, starting from line 0";
            $start = 0;
        }

        if ($final > $totalLines) {
            echo "There was an error, going till end of file";
            $final = $totalLines;
        }

        for ($counter = $start; $counter <= $final; $counter++) {
            if ($counter < 10) echo $counter . '  ';
            else echo $counter . ' ';

            $style = $counter == $exception->getLine() ? 'background-color: #FC8181' : 'background-color: none';
            echo '<a style="' . $style . '">' . $fileContentArray[$counter] . '</a>';
        }
    }
}

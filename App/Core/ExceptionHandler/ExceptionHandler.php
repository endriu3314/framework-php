<?php


namespace App\Core\ExceptionHandler;


class ExceptionHandler
{
    public static function getFileContentArrayFromPath($filePath)
    {
        $file = fopen($filePath, "r");

        $fileArray = [''];

        while (!feof($file)) {
            $fileArray[] = fgets($file);
        }

        fclose($file);

        return $fileArray;
    }

    public static function getFileContentStringFromPath($filePath)
    {
        return file_get_contents($filePath);
    }

    public static function printFileLinesFromArray($fileContentArray, $exception, $lines = 3, $type = "object")
    {
        $start = $type == "object" ? $exception->getLine() - $lines : $exception["line"] - $lines;
        $final = $type == "object" ? $exception->getLine() + $lines : $exception["line"] + $lines;
        $totalLines = count($fileContentArray);

        if ($start < 0) {
            echo "There was an error, starting from line 0";
            $start = 0;
        }

        if ($final > $totalLines-1) {
            echo "There was an error, going till end of file" . "<br/><br/>";
            $final = $totalLines-1;
        }

        for ($counter = $start; $counter <= $final; $counter++) {
            if ($counter < 10) echo $counter . '  ';
            else echo $counter . ' ';

            echo $fileContentArray[$counter];
        }
    }
}

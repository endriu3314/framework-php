<?php

namespace App\Core;

use App\Core\Exceptions\FileNotFoundException;
use SplFileInfo;

/**
 * Class Config
 * Read from YAML or JSON file.
 */
class Config
{
    /* @var mixed - Data of file*/
    private $data;

    /**
     * Config constructor.
     *
     * @param string $filePath - File path to config file
     *
     * @throws FileNotFoundException - Throw exception if file is not valid
     */
    public function __construct(string $filePath)
    {
        $fileData = new SplFileInfo($filePath);

        if (!$fileData->isFile()) {
            throw new FileNotFoundException("$filePath is not a file");
        }

        if (!$fileData->isReadable()) {
            throw new FileNotFoundException("$filePath is not readable");
        }

        if (extension_loaded('yaml')) {
            $this->data = yaml_parse_file($filePath);
        } elseif (extension_loaded('json')) {
            $json = file_get_contents($filePath);
            $this->data = json_decode($json, true);
        }
    }

    /**
     * Return data of file.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}

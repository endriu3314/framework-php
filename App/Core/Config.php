<?php

namespace App\Core;

use Exception;
use RuntimeException;
use SplFileInfo;

class Config
{
    private $data;

    public function __construct(string $filePath)
    {
        $fileData = new SplFileInfo($filePath);

        if (!$fileData->isFile()) {
            throw new RuntimeException("$filePath is not a file");
        }

        if (!$fileData->isReadable()) {
            throw new RuntimeException("$filePath is not readable");
        }

        if (extension_loaded("yaml"))
            $this->data = yaml_parse_file($filePath);
        else if (extension_loaded("json")) {
            $json = file_get_contents($filePath);
            $this->data = json_decode($json, true);
        }
    }

    public function getData(): array
    {
        return $this->data;
    }
}

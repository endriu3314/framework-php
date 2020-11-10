<?php

namespace App\Core\CLI;

class CLIHelper
{
    public function out($message)
    {
        echo $message;
    }

    public function newline($count = 1)
    {
        for ($counter = 0; $counter < $count; $counter++) {
            $this->out("\n");
        }
    }

    public function display($message, $foreground_color = null, $background_color = null)
    {
        $colors = new Colors();
        $message = $colors->getColoredString($message, $foreground_color, $background_color);
        $this->out($message);
    }
}

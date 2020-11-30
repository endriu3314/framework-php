<?php

namespace App\Core\CLI;

class CLIHelper
{
    public function out($message): void
    {
        echo $message;
    }

    public function newline(int $count = 1): void
    {
        for ($counter = 0; $counter < $count; $counter++) {
            $this->out("\n");
        }
    }

    public function display($message, $foreground_color = null, $background_color = null): void
    {
        $colors = new Colors();
        $message = $colors->getColoredString($message, $foreground_color, $background_color);
        $this->out($message);
    }
}

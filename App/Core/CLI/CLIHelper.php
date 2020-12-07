<?php

namespace App\Core\CLI;

class CLIHelper
{
    public function out($message): void
    {
        echo $message;
    }

    /**
     * Insert new line in console - default 1
     *
     * @param int $count
     */
    public function newline(int $count = 1): void
    {
        for ($counter = 0; $counter < $count; $counter++) {
            $this->out("\n");
        }
    }

    /**
     * Display a message in console
     *
     * @param string $message Message content
     * @param string|null $foreground_color Text color
     * @param string|null $background_color Background color
     */
    public function display(string $message, string $foreground_color = null, string $background_color = null): void
    {
        $colors = new Colors();
        $message = $colors->getColoredString($message, $foreground_color, $background_color);
        $this->out($message);
    }
}

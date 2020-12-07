<?php

namespace App\Core\CLI;

class Colors
{
    private array $foreground_colors = [
        'black' => '0;30',
        'dark_gray' => '1;30',
        'blue' => '0;34',
        'light_blue' => '1;34',
        'green' => '0;32',
        'light_green' => '1;32',
        'cyan' => '0;36',
        'light_cyan' => '1;36',
        'red' => '0;31',
        'light_red' => '1;31',
        'purple' => '0;35',
        'light_purple' => '1;35',
        'brown' => '0;33',
        'yellow' => '1;33',
        'light_gray' => '0;37',
        'white' => '1;37',
    ];

    private array $background_colors = [
        'black' => '40',
        'red' => '41',
        'green' => '42',
        'yellow' => '43',
        'blue' => '44',
        'magenta' => '45',
        'cyan' => '46',
        'light_gray' => '47',
    ];

    /**
     * Generate string with color
     *
     * @param string $string
     * @param string|null $foreground_color
     * @param string|null $background_color
     *
     * @return string
     */
    public function getColoredString(string $string, string $foreground_color = null, string $background_color = null): string
    {
        $colored_string = '';

        if (isset($this->foreground_colors[$foreground_color])) {
            $colored_string .= "\033[{$this->foreground_colors[$foreground_color]}m";
        }

        if (isset($this->background_colors[$background_color])) {
            $colored_string .= "\033[{$this->background_colors[$background_color]}m";
        }

        $colored_string .= "{$string}\033[0m";

        return $colored_string;
    }

    public function getForegroundColors(): array
    {
        return array_keys($this->foreground_colors);
    }

    public function getBackgroundColors(): array
    {
        return array_keys($this->background_colors);
    }
}

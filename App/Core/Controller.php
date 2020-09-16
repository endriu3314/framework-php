<?php

namespace App\Core;

class Controller
{
    public function buildView(array $views, bool $includeHeader = true, bool $includeFooter = true) {
        if ($includeHeader) {
            require VIEW . "layout" . DIRECTORY_SEPARATOR . "header.php";
        }

        foreach($views as $view) {
            if (file_exists($view))
                require $view;
        }

        if ($includeFooter) {
            require VIEW . "layout" . DIRECTORY_SEPARATOR . "footer.php";
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Http\Model\Post;

class home extends Controller
{
    public function index() {
        $this->buildView([
            VIEW . "home" . DIRECTORY_SEPARATOR . "index.php"
        ]);
    }

    public function exampleOne() {
        require VIEW . "layout/" . "header.php";
        require VIEW . "home/" . "example_one.php";
        require VIEW . "layout/" . "footer.php";
    }

    public function post() {
        $Post = new Post();
        $posts = $Post->getAll();

        $this->buildView([
            VIEW . "books" . DIRECTORY_SEPARATOR . "index.php"
        ]);
    }
}

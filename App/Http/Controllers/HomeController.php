<?php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Template;
use App\Helpers\Validator;
use App\Http\Model\Post;

class HomeController extends Controller
{
    public function test()
    {
        Template::view('home.html', [
            'title' => 'Home Page',
            'colors' => ['red', 'blue', 'green']
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Template;

class HomeController extends Controller
{
    public function homeView(): void
    {
        Template::view('home.html', [
            'title'  => 'Home Page',
            'colors' => ['red', 'blue', 'green'],
        ]);
    }
}

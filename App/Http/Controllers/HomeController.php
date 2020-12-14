<?php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Template;
use App\Http\Model\Test;

class HomeController extends Controller
{
    public function homeView(): void
    {
//        $firstTest = new Test();
//        $tests = $firstTest->all()->do()->get();
//        foreach ($tests as $test) {
//            var_dump($test->id);
//        }

        $firstTest = new Test();
        $tests = $firstTest->all()
            ->where('id', '>=', '1')
            ->where('id', '<', '4')
            ->do()->reverse()->get();
        foreach ($tests as $object) {
            var_dump($object->id);
        }

        Template::view('home.html', [
            'title'  => 'Home Page',
            'colors' => ['red', 'blue', 'green'],
        ]);
    }
}

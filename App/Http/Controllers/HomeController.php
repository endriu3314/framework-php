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

//        $firstTest = new Test();
//        $tests = $firstTest->all()
//            ->where('id', '>=', '1')
//            ->where('id', '<', '4')
//            ->do()->reverse()->get();
//        foreach ($tests as $object) {
//            var_dump($object->id);
//        }

//        $firstTest = new Test();
//        $firstTest->id = 2;
//        $firstTest = $firstTest->find();
//        var_dump($firstTest);

//        $firstTest = new Test();
//        $firstTest->username = 'andrei';
//        $firstTest->email = 'a.croitoru33@icloud.com';
//        $firstTest->password = password_hash('12345678', PASSWORD_BCRYPT);
//        $firstTest->activated = true;
//        $firstTest->create()->do();

//        $firstTest = new Test();
//        $firstTest->username = 'updated_andrei';
//        $firstTest->email = 'updated.a.@icloud.com';
//        var_dump($firstTest->update()->where('id', '=', '6')->do());

        $firstTest = new Test();
        $firstTest->id = 6;
        var_dump($firstTest->delete()->do());

        Template::view('home.html', [
            'title'  => 'Home Page',
            'colors' => ['red', 'blue', 'green'],
        ]);
    }
}

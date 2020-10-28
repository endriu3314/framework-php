<?php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Template;
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

    public function testModel()
    {
        $post = new Post();

        $post->id = 1;
        $post->title = "How2";
        $post->body = "asdjklaskdlfhjklasjdfljkasdf";

        //$post->save();

        //Post::findd(1);
        //Post::last();
        Post::select()::get();

        //echo $post->id;
    }
}

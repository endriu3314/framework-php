<?php

namespace App\Http\Model;

use App\Core\Model;

class Post extends Model
{
    private static $tableName = 'books';
    //private static $primaryKey = "idd";

    public $id;
    public $title;
    public $body;
}

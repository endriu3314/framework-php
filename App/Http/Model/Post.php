<?php

namespace App\Http\Model;

use App\Core\Model;
use App\Helpers\DebugPDO;

class Post extends Model
{
    private static $tableName = "books";
    //private static $primaryKey = "idd";

    public $id;
    public $title;
    public $body;
}

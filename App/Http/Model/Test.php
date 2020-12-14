<?php

namespace App\Http\Model;

use App\Core\Model;

class Test extends Model
{
    protected string $tableName = 'users';
    protected string $primaryKey = 'id';

    public $id;
}

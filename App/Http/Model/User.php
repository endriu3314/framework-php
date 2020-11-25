<?php

namespace App\Http\Model;

use App\Core\Model;

class User extends Model
{
    private static $tableName = 'users';
    private static $primaryKey = 'id';

    public $id;
    public $username;
    public $email;
    public $password;
    public $activated;
    public $register_at;
}

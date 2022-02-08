<?php

namespace App\Http\Model;

use AndreiCroitoru\FrameworkPhp\Model;

class Session extends Model
{
    private static $tableName = 'sessions';
    private static $primaryKey = 'session_id';

    public $session_id;
    public $user_id;
    public $login_time;
}

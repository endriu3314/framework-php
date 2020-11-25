<?php

namespace App\Http\Middleware;

use App\Core\Middleware;
use App\Http\Model\Auth;

class AuthMiddleware extends Middleware
{
    public function run()
    {
        if (!Auth::authenticated()) {
            $this->redirect('/login');
        }
    }
}

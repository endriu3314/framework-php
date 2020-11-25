<?php

namespace App\Http\Controllers\Auth;

use App\Core\Controller;
use App\Core\Helpers\Validator;
use App\Core\Template;
use App\Http\Model\User;

class RegisterController extends Controller
{
    public function registerView(): void
    {
        Template::view('register.html');
    }

    public function register()
    {
        $user = new User();

        $formData = $_POST;

        $username = $this->sanitize($formData['username']);
        $email = $this->sanitize($formData['email']);
        $password = $this->sanitize($formData['password']);

        Validator::is($username, "string,gt:6");
        Validator::is($email, "email");
        Validator::is($password, "string,gt:8");

        $user->username = $username;
        $user->email = $email;
        $user->password = hash('sha256', $password);
        $user->activated = 1;

        $user->create();

        return http_redirect('/register');
    }
}

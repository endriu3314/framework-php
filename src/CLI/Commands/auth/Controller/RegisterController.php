<?php

namespace App\Http\Controllers\Auth;

use AndreiCroitoru\FrameworkPhp\Controller;
use AndreiCroitoru\FrameworkPhp\Helpers\Validator;
use AndreiCroitoru\FrameworkPhp\Template;
use App\Http\Model\User;

class RegisterController extends Controller
{
    public function registerView(): void
    {
        Template::view('register.html', [
            'errors' => $this->validateErrors
        ]);
    }

    public function register(): void
    {
        $user = new User();

        $formData = $_POST;

        $username = $this->sanitize($formData['username']);
        $email = $this->sanitize($formData['email']);
        $password = $this->sanitize($formData['password']);

        $validator = $this->validate([
            $username => 'string,gt:6',
            $email => 'email',
            $password => 'string,gt:8',
        ]);

        if (!$validator) {
            Template::view('register.html', [
                'errors' => $this->validateErrors
            ]);
            return;
        }

        $user->username = $username;
        $user->email = $email;
        $user->password = hash('sha256', $password);
        $user->activated = 1;

        $user->create();

        $this->redirect()->url('/login')->do();
    }
}

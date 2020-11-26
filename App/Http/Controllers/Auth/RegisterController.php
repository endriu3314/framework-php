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

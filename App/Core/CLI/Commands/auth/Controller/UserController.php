<?php

namespace App\Http\Controllers\Auth;

use App\Core\Controller;
use App\Core\Helpers\Validator;
use App\Core\Template;
use App\Http\Model\User;

class UserController extends Controller
{
    public function update(): bool
    {
        $user = new User();
        $formData = $_POST;

        $id = $formData['id'];
        Validator::is($id, "int");

        $user = $user->find($id);

        $username = $this->sanitize($formData['username']);
        $email = $this->sanitize($formData['email']);
        $password = $this->sanitize($formData['password']);

        $this->validator($username, $email, $password);

        $user->username = $username;
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_BCRYPT);

        return $user->update();
    }

    public function delete(): bool
    {
        $user = new User();
        $formData = $_POST;

        $id = $this->sanitize($formData['id']);
        Validator::is($id, "int");

        $user->id = $id;
        return $user->delete();
    }

    public function dashboardView(): void
    {
        Template::view('dashboard.html');
    }
}

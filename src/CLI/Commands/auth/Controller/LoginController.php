<?php

namespace App\Http\Controllers\Auth;

use AndreiCroitoru\FrameworkPhp\Controller;
use AndreiCroitoru\FrameworkPhp\Template;
use App\Http\Model\Auth;
use App\Http\Model\Session;
use App\Http\Model\User;

class LoginController extends Controller
{
    public function loginView(): void
    {
        Template::view('login.html', [
            'errors' => $this->validateErrors
        ]);
    }

    public function authenticate(): void
    {
        $user = new User();
        $formData = $_POST;

        $email = $this->sanitize($formData['email']);
        $password = $this->sanitize($formData['password']);

        $validator = $this->validate([
            $email => 'email',
            $password => 'string,gt:8'
        ]);

        if (!$validator) {
            Template::view('login.html', [
                'errors' => $this->validateErrors
            ]);
            return;
        }

        $users = $user->selectAllWhere([
            'email' => $email,
        ]);

        if (is_array($users)) {
            $user->password = $users[0]['password'];
        }

        if (password_verify($password, $user->password)) {
            $user->id = $users[0]['id'];
            $user->email = $users[0]['email'];
            $user->username = $users[0]['username'];
            $user->activated = $users[0]['activated'];
            $user->register_at = $users[0]['register_at'];

            $this->registerSession($user->id);
            $this->redirect()->url('/dashboard')->do();
        }

        $this->redirect()->url('/register')->do();
    }

    private function registerSession(int $userId): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $session = new Session();
            $session = $session->find(session_id());

            if (isset($session->user_id)) {
                if ($session->user_id === (string)$userId && $session->session_id === session_id()) {
                    $this->updateExistingSession($session, $userId);
                }
            } else {
                $this->registerNewSession($userId);
            }

            setcookie("user-id", hash('sha1', $userId));
        }
    }

    private function registerNewSession(int $userId): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $session = new Session();

            $session->session_id = session_id();
            $session->user_id = $userId;
            $now = new \DateTime('now');
            $session->login_time = $now->format('Y-m-d H:i:s');

            $session->create();
        }
    }

    private function updateExistingSession(Session $session, int $userId): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $session->session_id = session_id();
            $session->user_id = $userId;
            $now = new \DateTime('now');
            $session->login_time = $now->format('Y-m-d H:i:s');

            $session->update();
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $session = new Session();
            $session->session_id = session_id();
            $session->user_id = Auth::auth()->id;

            $session->delete();

            session_unset();
            session_destroy();

            $this->redirect()->back()->do();
        }
    }
}

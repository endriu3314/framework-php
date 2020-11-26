<?php

namespace App\Http\Model;

use App\Core\Model;

class Auth extends Model
{
    public static function authenticated(): bool
    {
        if (!session_status() === PHP_SESSION_ACTIVE) {
            return false;
        }

        if (!isset($_COOKIE['user-id'])) {
            return false;
        }

        $session = new Session();
        $session = $session->find(session_id());

        if (session_id() !== $session->session_id) {
            return false;
        }

        if ($_COOKIE['user-id'] !== hash('sha1', $session->user_id)) {
            return false;
        }

        return true;
    }

    public static function auth(): User
    {
        if (!session_status() === PHP_SESSION_ACTIVE) {
            exit;
        }

        if (!isset($_COOKIE['user-id'])) {
            exit;
        }

        $session = new Session();
        $session = $session->find(session_id());

        if (session_id() !== $session->session_id) {
            exit;
        }

        if ($_COOKIE['user-id'] !== hash('sha1', $session->user_id)) {
            exit;
        }

        $user = new User();
        return $user->find($session->user_id);
    }
}

<?php
// Убедимся, что сессия еще не начата
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Session {
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function destroy() {
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    public static function isAdmin() {
        return self::get('role') === 'admin';
    }

    public static function isSuperUser() {
        return self::get('role') === 'superuser';
    }
} 
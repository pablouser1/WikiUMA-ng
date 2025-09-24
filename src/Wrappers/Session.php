<?php

namespace App\Wrappers;

class Session
{
    public static function start(): void
    {
        session_start([
            'cookie_secure' => 1,
            'cookie_httponly' => 1,
        ]);
    }

    public static function destroy(): void
    {
        session_destroy();
    }

    public static function hasStarted(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public static function isLoggedIn(): bool
    {
        return self::hasStarted() && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
    }

    public static function login(int $id): void
    {
        $_SESSION['loggedin'] = true;
        $_SESSION['id'] = $id;
    }
}

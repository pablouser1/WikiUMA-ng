<?php
namespace App\Helpers;

class Misc {
    static public function url(string $endpoint = ''): string {
        return self::env('APP_URL', '') . $endpoint;
    }

    static public function env(string $key, $default_value = '') {
        return $_ENV[$key] ?? $default_value;
    }

    static public function redirect(string $path) {
        $location = self::url($path);
        header("Location: $location");
    }

    static public function isLoggedIn(): bool {
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1;
    }
}

<?php
namespace App\Helpers;

class Misc {
    static public function url(string $endpoint = '', array $query = []): string {
        $url = self::env('APP_URL', '') . $endpoint;
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }
        return $url;
    }

    static public function env(string $key, $default_value = '') {
        return $_ENV[$key] ?? $default_value;
    }

    static public function redirect(string $endpoint, array $query = []) {
        $url = self::url($endpoint, $query);
        header("Location: $url");
    }

    static public function isLoggedIn(): bool {
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1;
    }
}

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

    static public function parseHTML(?string $html): ?\DOMDocument {
        if ($html) {
            $doc = new \DOMDocument();
            $success = @$doc->loadHTML($html);
            if ($success) {
                return $doc;
            }
        }
        return null;
    }

    static public function getPage(): int {
        return isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
    }

    static public function sanitizeSort(string $sort, string $order): bool {
        $sortValid = in_array($sort, ['created_at', 'votes'], true);
        $orderValid = in_array($order, ['asc', 'desc'], true);
        return $sortValid && $orderValid;
    }
}

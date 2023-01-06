<?php
namespace App\Helpers;

use Gregwar\Captcha\CaptchaBuilder;

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

    static public function isLoggedIn(bool $isAdmin = false): bool {
        $loggedin = isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
        return $isAdmin ? $loggedin && isset($_SESSION['admin']) && $_SESSION['admin'] == 1 : $loggedin;
    }

    static public function contact(): string {
        return self::env('APP_CONTACT', self::url('/'));
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

    static public function isCaptchaValid(string $captcha): bool {
        $builder = new CaptchaBuilder($_SESSION['phrase']);
        $valid = $builder->testPhrase($captcha);

        // Avoid using captcha more than once
        unset($_SESSION['phrase']);

        return $valid;
    }

    static public function getPage(): int {
        return isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
    }

    static public function sanitizeSort(string $sort, string $order): bool {
        $sortValid = in_array($sort, ['created_at', 'votes'], true);
        $orderValid = in_array($order, ['asc', 'desc'], true);
        return $sortValid && $orderValid;
    }

    static public function joinSubject(int $asignatura_id, int $plan_id): string {
        return $asignatura_id . ';' . $plan_id;
    }

    static public function splitSubject(string $data): ?object {
        // Separar id e id del plan
        // 0: id asignatura
        // 1: id plan
        $asig_arr = explode(';', $data);
        // Nos aseguramos que sea exactamente dos elementos
        if (count($asig_arr) !== 2) {
            return null;
        }

        $subject = new \stdClass;
        $subject->asig = $asig_arr[0];
        $subject->plan = $asig_arr[1];

        return $subject;
    }
}

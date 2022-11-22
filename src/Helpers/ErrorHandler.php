<?php
namespace App\Helpers;

class ErrorHandler {
    static public function show(int $code = 400, string $body = '', bool $exit = true) {
        http_response_code($code);
        Wrappers::plates('error', [
            'code' => $code,
            'body' => $body
        ]);
        if ($exit) exit;
    }
}

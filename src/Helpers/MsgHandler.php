<?php
namespace App\Helpers;

class MsgHandler {
    static public function show(int $code = 400, string $body = '', string $title = '', bool $exit = true) {
        http_response_code($code);
        Wrappers::plates('message', [
            'code' => $code,
            'title' => $title,
            'body' => $body
        ]);
        if ($exit) exit;
    }
}

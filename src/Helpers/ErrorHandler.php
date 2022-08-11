<?php
namespace App\Helpers;

class ErrorHandler {
    static public function show(int $code = 400, string $body = '', bool $exit = true) {
        http_response_code($code);
        $latte = Wrappers::latte();
        $latte->render(Misc::getView('error'), [
            'title' => 'Error',
            'code' => $code,
            'body' => $body
        ]);
        if ($exit) exit;
    }
}

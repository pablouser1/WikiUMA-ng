<?php
namespace App\Helpers;

use App\Models\Response;

class MsgHandler {
    static public function show(int $code = 400, string $body = '', string $title = 'Error'): void {
        http_response_code($code);
        Wrappers::plates('message', [
            'code' => $code,
            'title' => $title,
            'body' => $body
        ]);
    }

    static public function showApi(Response $res) {
        self::show($res->code, $res->error !== null ? $res->error : '', 'Error Scraping');
    }
}

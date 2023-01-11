<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\MsgHandler;
use App\Helpers\Wrappers;

class CentrosController {
    static public function get() {
        $api = new Api;
        $res = $api->centros();
        if (!$res->success) {
            MsgHandler::showApi($res);
        }

        Wrappers::plates('centros', [
            'centros' => $res->data
        ]);
    }
}

<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\MsgHandler;
use App\Helpers\Wrappers;

class SearchController {
    static public function get() {
        $nombre = $_GET['nombre'] ?? '';
        $apellido_1 = $_GET['apellido_1'] ?? '';
        $apellido_2 = $_GET['apellido_2'] ?? '';

        $api = new Api;

        $res = $api->buscar($nombre, $apellido_1, $apellido_2);

        if (!$res->success) {
            MsgHandler::showApi($res);
            return;
        }

        Wrappers::plates('search', [
            'results' => $res->data
        ]);
    }
}

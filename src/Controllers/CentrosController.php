<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\ErrorHandler;
use App\Helpers\Wrappers;

class CentrosController {
    static public function get() {
        $api = new Api;
        $centros = $api->centros();
        if (!$centros) {
            ErrorHandler::show(502, 'Ha habido un error consiguiendo la lista de centros');
        }

        Wrappers::plates('centros', [
            'centros' => $centros
        ]);
    }
}

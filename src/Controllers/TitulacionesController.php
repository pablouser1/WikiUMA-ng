<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\ErrorHandler;
use App\Helpers\Wrappers;

class TitulacionesController {
    static public function get(int $id) {
        $api = new Api;
        $titulaciones = $api->titulaciones($id);
        if (!$titulaciones) {
            ErrorHandler::show(404, 'No encontrado');
        }
        Wrappers::plates('titulaciones', [
            'title' => $titulaciones[0]->CENTRO,
            'titulaciones' => $titulaciones
        ]);
    }
}

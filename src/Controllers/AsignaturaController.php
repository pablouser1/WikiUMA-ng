<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\ErrorHandler;
use App\Helpers\Wrappers;

class AsignaturaController {
    static public function get(int $id, int $plan_id) {
        $api = new Api;
        $asignatura = $api->asignatura($id, $plan_id);
        if (!$asignatura) {
            ErrorHandler::show(404, 'Asignatura no encontrada');
        }

        Wrappers::plates('asignatura', [
            'title' => $asignatura->nombre,
            'asignatura' => $asignatura
        ]);
    }
}

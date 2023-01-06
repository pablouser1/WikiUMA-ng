<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\MsgHandler;
use App\Helpers\Wrappers;

class PlanController {
    static public function get(int $id) {
        $api = new Api;
        $plan = $api->plan($id);
        if (!$plan) {
            MsgHandler::show(404, 'Plan no encontrado');
        }
        $cursos = [];
        foreach ($plan->asignaturas as $asignatura) {
            $cursos[intval($asignatura->curso)][] = $asignatura;
        }

        Wrappers::plates('plan', [
            'title' => 'Plan ' . $id,
            'cursos' => $cursos,
            'duracion' => intval($plan->duracion),
            'plan_id' => $id
        ]);
    }
}

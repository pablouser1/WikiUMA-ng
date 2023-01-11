<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\MsgHandler;
use App\Helpers\Wrappers;

class PlanController {
    static public function get(int $id) {
        $api = new Api;
        $res = $api->plan($id);
        if (!$res->success) {
            MsgHandler::showApi($res);
        }
        $plan = $res->data;
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

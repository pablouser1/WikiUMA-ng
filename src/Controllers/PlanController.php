<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\Misc;
use App\Helpers\Wrappers;

class PlanController {
    static public function show(int $id) {
        $api = new Api;
        $plan = $api->plan($id);
        if ($plan) {
            $cursos = [];
            foreach ($plan->asignaturas as $asignatura) {
                $cursos[intval($asignatura->curso)][] = $asignatura;
            }
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('plan'), [
                'title' => 'Plan',
                'cursos' => $cursos,
                'duracion' => intval($plan->duracion),
                'plan_id' => $id
            ]);
        }
    }
}

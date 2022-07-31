<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\Misc;
use App\Helpers\Wrappers;

class AsignaturaController {
    static public function show(int $id, int $plan_id) {
        $api = new Api;
        $asignatura = $api->asignatura($id, $plan_id);
        if ($asignatura) {
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('asignatura'), [
                'title' => 'Asignatura',
                'asignatura' => $asignatura
            ]);
        }
    }
}

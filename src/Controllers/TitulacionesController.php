<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\Misc;
use App\Helpers\Wrappers;

class TitulacionesController {
    static public function show(int $id) {
        $api = new Api;
        $titulaciones = $api->titulaciones($id);
        if ($titulaciones) {
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('titulaciones'), [
                'title' => 'Titulaciones',
                'titulaciones' => $titulaciones
            ]);
        }
    }
}

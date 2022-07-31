<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\Misc;
use App\Helpers\Wrappers;

class CentrosController {
    static public function show() {
        $api = new Api;
        $centros = $api->centros();
        if ($centros) {
            $latte = Wrappers::latte();
            $latte->render(Misc::getView('centros'), [
                'title' => 'Centros',
                'centros' => $centros
            ]);
        }
    }
}

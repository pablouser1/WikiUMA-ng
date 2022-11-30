<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\Wrappers;

class SearchController {
    static public function get() {
        $nombre = $_GET['nombre'] ?? '';
        $apellido_1 = $_GET['apellido_1'] ?? '';
        $apellido_2 = $_GET['apellido_2'] ?? '';

        $api = new Api;

        $results = $api->buscar($nombre, $apellido_1, $apellido_2);
        Wrappers::plates('search', [
            'results' => $results
        ]);
    }
}

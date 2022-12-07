<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Items\Review;

class AsignaturaController {
    static public function get(int $id, int $plan_id) {
        $api = new Api;
        $asignatura = $api->asignatura($id, $plan_id);
        if (!$asignatura) {
            ErrorHandler::show(404, 'Asignatura no encontrada');
        }

        $page = Misc::getPage();
        $sort = $_GET['sort'] ?? 'created_at';
        $order = $_GET['order'] ?? 'asc';
        $review = new Review;
        $reviews = $review->getAllFrom($asignatura->cod_asig, $page, $sort, $order);
        $stats = $review->statsOne($asignatura->cod_asig);
        Wrappers::plates('asignatura', [
            'title' => $asignatura->nombre,
            'asignatura' => $asignatura,
            'reviews' => $reviews,
            'stats' => $stats,
            'plan_id' => $plan_id
        ]);
    }
}

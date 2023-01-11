<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\MsgHandler;
use App\Helpers\Misc;
use App\Helpers\Subject;
use App\Helpers\Wrappers;
use App\Items\Review;

class AsignaturaController {
    static public function get(int $id, int $plan_id) {
        $api = new Api;
        $res = $api->asignatura($id, $plan_id);
        if (!$res->success) {
            MsgHandler::show(404, 'Asignatura no encontrada');
            return;
        }

        $asignatura = $res->data;

        $page = Misc::getPage();
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
        $order = isset($_GET['order']) ? $_GET['sort'] : 'desc';
        $review = new Review;

        $full_subject = Subject::join($asignatura->cod_asig, $plan_id);
        $reviews = $review->getAllFrom($full_subject, $page, $sort, $order);
        $stats = $review->statsOne($full_subject);
        Wrappers::plates('asignatura', [
            'title' => $asignatura->nombre,
            'asignatura' => $asignatura,
            'reviews' => $reviews,
            'stats' => $stats,
            'plan_id' => $plan_id
        ]);
    }
}

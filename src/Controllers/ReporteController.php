<?php
namespace App\Controllers;

use App\Helpers\Captcha;
use App\Helpers\MsgHandler;
use App\Helpers\Misc;
use App\Helpers\Mode;
use App\Helpers\Wrappers;
use App\Items\Report;
use App\Items\Review;

class ReporteController {
    static public function get(int $review_id) {
        $reviewDb = new Review;
        $review = $reviewDb->get($review_id);
        if (!$review) {
            MsgHandler::show(404, 'Esa reseña no existe');
            return;
        }

        Wrappers::plates('reporte', [
            'review' => $review
        ]);
    }

    static public function post(int $review_id) {
        if (!Mode::handle(2)) {
            MsgHandler::show(401, '¡Necesitas iniciar sesión!');
            return;
        }

        // Verify captcha
        $valid = Captcha::validate($_POST['captcha']);
        if (!$valid) {
            MsgHandler::show(400, 'Captcha inválido');
            return;
        }

        $reason = '';

        if (isset($_POST['reason']) && !empty($_POST['reason'])) {
            $reason = htmlspecialchars(trim($_POST['reason']));
        }

        $db = Wrappers::db();

        $reviewDb = new Review($db);
        $review = $reviewDb->get($review_id);
        if (!$review) {
            MsgHandler::show(404, 'Esa reseña no existe');
            return;
        }

        $reportDb = new Report($db);
        $success = $reportDb->add($review->id, $reason);
        if (!$success) {
            MsgHandler::show(500, 'Ha habido un error al procesar tu solicitud');
            return;
        }

        MsgHandler::show(200, 'Gracias por hacer de WikiUMA un sitio mejor para todos ❤️', 'Tu informe ha sido procesado correctamente');
    }

    /**
     * Elimina reporte
     */
    static public function delete(int $id) {
        if (!Misc::isLoggedIn(true)) {
            Misc::redirect('/login');
            return;
        }

        $report = new Report();
        $report->delete($id);
        Misc::redirect('/admin/reports');
    }
}

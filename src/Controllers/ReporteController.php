<?php
namespace App\Controllers;

use App\Helpers\MsgHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Items\Report;
use App\Items\Review;
use Gregwar\Captcha\CaptchaBuilder;

class ReporteController {
    static public function get(int $review_id) {
        $reviewDb = new Review;
        $review = $reviewDb->get($review_id);
        if (!$review) {
            MsgHandler::show(404, 'Esa reseña no existe');
        }

        Wrappers::plates('reporte', [
            'review' => $review
        ]);
    }

    static public function post(int $review_id) {
        $reason = '';

        if (isset($_POST['reason']) && !empty($_POST['reason'])) {
            $reason = htmlspecialchars(trim($_POST['reason']));
        }
        $db = Wrappers::db();

        $reviewDb = new Review($db);
        $review = $reviewDb->get($review_id);
        if (!$review) {
            MsgHandler::show(404, 'Esa reseña no existe');
        }

        // Verify captcha
        $builder = new CaptchaBuilder($_SESSION['phrase']);
        $valid = $builder->testPhrase($_POST['captcha']);
        // Avoid using captcha more than once
        unset($_SESSION['phrase']);
        if (!$valid) {
            die("Captcha inválido");
        }
        $reportDb = new Report($db);
        $reportDb->add($review->id, $reason);
        Misc::redirect('/');
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

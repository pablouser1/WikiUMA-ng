<?php
namespace App\Controllers;

use App\DB;
use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use Gregwar\Captcha\CaptchaBuilder;

class ReporteController {
    static public function get(int $review_id) {
        $db = new DB;
        $review = $db->getReview($review_id);
        if (!$review) {
            ErrorHandler::show(404, 'Esa reseña no existe');
        }

        $latte = Wrappers::latte();
        $latte->render(Misc::getView('reporte'), [
            'title' => 'Reporte',
            'review' => $review
        ]);
    }

    static public function post(int $review_id) {
        session_start();
        $reason = '';

        if (isset($_POST['reason']) && !empty($_POST['reason'])) {
            $reason = htmlspecialchars(trim($_POST['reason']));
        }

        $db = new DB;
        $review = $db->getReview($review_id);
        if (!$review) {
            ErrorHandler::show(404, 'Esa reseña no existe');
        }

        // Verify captcha
        $builder = new CaptchaBuilder($_SESSION['phrase']);
        $valid = $builder->testPhrase($_POST['captcha']);
        // Avoid using captcha more than once
        unset($_SESSION['phrase']);
        if (!$valid) {
            die("Captcha inválido");
        }
        $db->addReport($review->id, $reason);
        Misc::redirect('/');
    }

    /**
     * Elimina reporte, no la review
     */
    static public function delete(int $id) {
        session_start();
        if (!isset($_SESSION['loggedin'])) {
            Misc::redirect('/admin/login');
            exit;
        }

        $db = new DB;
        $db->deleteReport($id);
        Misc::redirect('/admin');
    }
}

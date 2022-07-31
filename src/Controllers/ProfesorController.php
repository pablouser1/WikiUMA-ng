<?php
namespace App\Controllers;

use App\Api;
use App\DB;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use Gregwar\Captcha\CaptchaBuilder;

class ProfesorController {
    static public function get() {
        if (isset($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
            $email = $_GET['email'];
            $api = new Api;
            $profesor = $api->profesor($email);
            if ($profesor) {
                // Get reviews from db
                $db = new DB();
                $reviews = $db->getReviews($profesor->idnc);
                $stats = $db->getStatsTeacher($profesor->idnc);
                $latte = Wrappers::latte();
                $latte->render(Misc::getView('profesor'), [
                    'title' => $profesor->nombre,
                    'profesor' => $profesor,
                    'reviews' => $reviews,
                    'stats' => $stats
                ]);
            }
        }
    }

    static public function post() {
        session_start();
        if (!(isset($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL))) {
            die('Necesitas enviar un email válido');
        }

        if (!isset($_SESSION['phrase'])) {
            die('Captcha no existente');
        }

        $username = '';

        if (isset($_POST['username']) && !empty($_POST['username'])) {
            $username = htmlspecialchars(trim($_POST['username']));
        }

        $message = '';

        if (isset($_POST['message']) && !empty($_POST['username'])) {
            $message = htmlspecialchars(trim($_POST['message']));
        }

        if (!(isset($_POST['note'], $_POST['captcha']) && is_numeric($_POST['note']))) {
            die("Datos de formulario inválidos");
        }

        $note = floatval($_POST['note']);

        if (!((0 <= $note) && ($note <= 10))) {
            die("Número fuera de rango");
        }

        // Verify captcha
        $builder = new CaptchaBuilder($_SESSION['phrase']);
        $valid = $builder->testPhrase($_POST['captcha']);

        // Avoid using captcha more than once
        session_unset();
        session_destroy();
        if (!$valid) {
            die("Captcha inválido");
        }

        $email = $_GET['email'];
        $api = new Api;
        $profesor = $api->profesor($email);
        if ($profesor) {
            $db = new DB;
            $db->addReview($profesor->idnc, $username, $note, $message);
            Misc::redirect('/profesores?email=' . $email);
        }
    }
}

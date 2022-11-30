<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Items\Review;
use Gregwar\Captcha\CaptchaBuilder;

class ReviewController {
    static public function post() {
        if (!isset($_POST['accepted'])) {
            ErrorHandler::show(400, 'Tienes que aceptar los términos de uso');
        }

        if (!isset($_GET['data'])) {
            ErrorHandler::show(400, 'Tienes que enviar un payload válido');
        }

        if (!(isset($_GET['subject']) && is_numeric($_GET['subject']))) {
            ErrorHandler::show(400, 'No hay modo');
        }

        if (!isset($_SESSION['phrase'])) {
            ErrorHandler::show(400, 'Captcha no existente');
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
            ErrorHandler::show(400, 'Datos de formulario inválidos');
        }

        $note = floatval($_POST['note']);

        if (!((0 <= $note) && ($note <= 10))) {
            ErrorHandler::show(400, 'Número fuera de rango (0-10)');
        }

        // Verify captcha
        $builder = new CaptchaBuilder($_SESSION['phrase']);
        $valid = $builder->testPhrase($_POST['captcha']);

        // Avoid using captcha more than once
        unset($_SESSION['phrase']);
        if (!$valid) {
            ErrorHandler::show(400, 'Captcha inválido');
        }

        $data = $_GET['data'];
        $subject = boolval($_GET['subject']);
        $to = '';
        $redirect = [];
        $api = new Api;
        if ($subject) {
            // Separar id e id del plan
            // 0: id asignatura
            // 1: id plan
            $asignatura_array = explode(';', $data);
            $asignatura = $api->asignatura($asignatura_array[0], $asignatura_array[1]);
            if (!$asignatura) {
                ErrorHandler::show(404, 'Asignatura no encontrado');
            }

            $to = $asignatura->cod_asig;
            $redirect = [
                '/asignaturas/' . $asignatura_array[0] . '/' . $asignatura_array[1],
                []
            ];
        } else {
            $profesor = $api->profesor($data);
            if (!$profesor) {
                ErrorHandler::show(404, 'Profesor no encontrado');
            }

            $to = $profesor->idnc;
            $redirect = [
                '/profesores',
                ['email' => $data]
            ];
        }

        $review = new Review();
        $review->add($to, $username, $note, $message, intval($subject));
        Misc::redirect($redirect[0], $redirect[1]);
    }

    static public function delete(int $id) {
        if (!Misc::isLoggedIn()) {
            Misc::redirect('/admin/login');
            exit;
        }

        $review = new Review();
        $review->delete($id);
        Misc::redirect('/admin');
    }

    static public function like(int $id) {
        self::changeVote($id, true);
    }

    static public function dislike(int $id) {
        self::changeVote($id, false);
    }

    static private function changeVote(int $id, bool $more) {
        if (isset($_SESSION['voted'])) {
            if (in_array($id, $_SESSION['voted'])) {
                ErrorHandler::show(400, '¡Ya has votado!');
            }
        }
        if (!isset($_GET['back'])) {
            ErrorHandler::show(400, 'Faltan parámetros');
        }

        if(!filter_var($_GET['back'], FILTER_VALIDATE_URL)) {
            ErrorHandler::show(400, 'Parámetros inválidos');
        }

        $review = new Review();
        $review->vote($id, $more);
        if (!isset($_SESSION['voted'])) {
            $_SESSION['voted'] = [$id];
        } else {
            $_SESSION['voted'][] = $id;
        }
        Misc::redirect($_GET['back']);
    }
}

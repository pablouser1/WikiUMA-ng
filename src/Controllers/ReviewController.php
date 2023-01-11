<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\Captcha;
use App\Helpers\MsgHandler;
use App\Helpers\Misc;
use App\Helpers\Mode;
use App\Helpers\Subject;
use App\Items\Review;

class ReviewController {
    static public function post() {
        if (!Mode::handle(1)) {
            MsgHandler::show(401, '¡Tienes que iniciar sesión!');
            return;
        }

        self::__validateInput();

        // Username
        $username = '';
        if (isset($_POST['username']) && !empty($_POST['username'])) {
            $username = htmlspecialchars(trim($_POST['username']), ENT_COMPAT);
        }

        // Message
        $message = '';
        if (isset($_POST['message']) && !empty($_POST['message'])) {
            $message = htmlspecialchars(trim($_POST['message']), ENT_COMPAT);
        }

        // Note
        $note = floatval($_POST['note']);
        if (!((0 <= $note) && ($note <= 10))) {
            MsgHandler::show(400, 'Número fuera de rango (0-10)');
            return;
        }

        // Tags (if any)
        $tags = [];
        if (isset($_POST['tags']) && is_array($_POST['tags']) && !empty($_POST['tags'])) {
            foreach ($_POST['tags'] as $tag) {
                if (is_numeric($tag)) {
                    $tags[] = intval($tag);
                }
            }
        }

        // Verify captcha
        $valid = Captcha::validate($_POST['captcha']);
        if (!$valid) {
            MsgHandler::show(400, 'Captcha inválido');
            return;
        }

        $data = $_GET['data'];
        $api = new Api;

        $res = boolval($_GET['subject']) ? self::__handleSubjects($data, $api) : self::__handleTeachers($data, $api);

        $to = $res->to;
        $redirect = $res->redirect;

        $review = new Review();
        $review->add($to, $username, $note, $message, intval($_GET['subject']), $tags);
        Misc::redirect($redirect[0], $redirect[1]);
    }

    static public function delete(int $id) {
        if (!Misc::isLoggedIn(true)) {
            Misc::redirect('/login');
            return;
        }

        $review = new Review();
        $review->delete($id);
        Misc::redirect('/admin/reviews');
    }

    static public function like(int $id) {
        self::changeVote($id, true);
    }

    static public function dislike(int $id) {
        self::changeVote($id, false);
    }

    static private function changeVote(int $id, bool $more) {
        if (isset($_SESSION['voted']) && in_array($id, $_SESSION['voted'])) {
            MsgHandler::show(400, '¡Ya has votado!');
            return;
        }

        if (!isset($_GET['back'])) {
            MsgHandler::show(400, 'Faltan parámetros');
            return;
        }

        if(!filter_var($_GET['back'], FILTER_VALIDATE_URL)) {
            MsgHandler::show(400, 'Parámetros inválidos');
            return;
        }

        $review = new Review();
        $review->vote($id, $more);
        if (!isset($_SESSION['voted'])) {
            $_SESSION['voted'] = [$id];
        } else {
            $_SESSION['voted'][] = $id;
        }

        $url = $_GET['back'];

        header("Location: $url");
    }

    static private function __validateInput() {
        if (!isset($_POST['accepted'])) {
            MsgHandler::show(400, 'Tienes que aceptar los términos de uso');
            return;
        }

        if (!isset($_GET['data'])) {
            MsgHandler::show(400, 'Tienes que enviar un payload válido');
            return;
        }

        if (!(isset($_GET['subject']) && is_numeric($_GET['subject']))) {
            MsgHandler::show(400, 'No hay modo');
            return;
        }

        if (!isset($_SESSION['phrase'])) {
            MsgHandler::show(400, 'Captcha no existente');
            return;
        }

        if (!(isset($_POST['note'], $_POST['captcha']) && is_numeric($_POST['note']))) {
            MsgHandler::show(400, 'Datos de formulario inválidos');
            return;
        }
    }

    static private function __handleTeachers(string $data, Api $api): object {
        $res = new \stdClass;

        $apiRes = $api->profesor($data);
        if (!$apiRes->success) {
            MsgHandler::showApi($apiRes);
            return;
        }

        $profesor = $apiRes->data;

        $res->to = $profesor->idnc;
        $res->redirect = [
            '/profesores',
            ['email' => $data]
        ];

        return $res;
    }

    static private function __handleSubjects(string $data, Api $api): object {
        $res = new \stdClass;

        $subject_spl = Subject::split($data);
        // Nos aseguramos que sea válido
        if (!$subject_spl) {
            MsgHandler::show(400, 'Datos inválidos');
        }

        $asignatura = $api->asignatura($subject_spl->asig, $subject_spl->plan);
        if (!$asignatura) {
            MsgHandler::show(404, 'Asignatura no encontrada');
        }

        $res->to = $data;
        $res->redirect = [
            '/asignaturas/' . $subject_spl->asig . '/' . $subject_spl->plan,
            []
        ];

        return $res;
    }
}

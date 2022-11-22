<?php
namespace App\Controllers;

use App\Api;
use App\DB;
use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use Gregwar\Captcha\CaptchaBuilder;

class ReviewController {
    static public function post() {
        if (!(isset($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL))) {
            ErrorHandler::show(400, 'Tienes que enviar un email válido');
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

        $email = $_GET['email'];
        $api = new Api;
        $profesor = $api->profesor($email);
        if (!$profesor) {
            ErrorHandler::show(404, 'Profesor no encontrado');
        }

        $db = new DB;
        $db->addReview($profesor->idnc, $username, $note, $message);
        Misc::redirect('/profesores?email=' . $email);
    }

    static public function delete(int $id) {
        if (!isset($_SESSION['loggedin'])) {
            Misc::redirect('/admin/login');
            exit;
        }
        $db = new DB;
        $db->deleteReview($id);
    }
}

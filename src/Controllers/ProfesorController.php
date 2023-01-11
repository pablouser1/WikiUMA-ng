<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\MsgHandler;
use App\Helpers\Misc;
use App\Helpers\Mode;
use App\Helpers\Wrappers;
use App\Items\Review;
use App\Items\Tag;

class ProfesorController {
    static public function get() {
        if (!Mode::handle(2)) {
            MsgHandler::show(401, '¡Tienes que iniciar sesión!');
        }

        if (isset($_GET['email'])) {
            self::byEmail();
        } else if (isset($_GET['idnc'])) {
            self::byIdnc();
        } else {
            MsgHandler::show(400, "Parámetros inválidos");
        }
    }

    static private function byEmail() {
        if (!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
            MsgHandler::show(400, 'Tienes que enviar una dirección de correo válida');
        }
        $email = $_GET['email'];
        $api = new Api;
        $res = $api->profesor($email);

        if (!$res->success) {
            MsgHandler::showApi($res);
        }

        $profesor = $res->data;

        $page = Misc::getPage();
        $sort = $_GET['sort'] ?? 'created_at';
        $order = $_GET['order'] ?? 'desc';
        $db = Wrappers::db();

        // Get reviews
        $reviewDb = new Review($db);
        $reviews = $reviewDb->getAllFrom($profesor->idnc, $page, $sort, $order);
        $stats = $reviewDb->statsOne($profesor->idnc);

        // Get tags
        $tagDb = new Tag($db);
        $tags = $tagDb->getAll();
        Wrappers::plates('profesor', [
            'title' => $profesor->nombre,
            'profesor' => $profesor,
            'reviews' => $reviews,
            'tags' => $tags,
            'stats' => $stats
        ]);
    }

    /**
     * Tries to convert idnc request to email
     */
    static private function byIdnc() {
        $idnc = $_GET['idnc'];
        $api = new Api;
        $res = $api->profesorWeb($idnc);
        if (!$res->success) {
            MsgHandler::showApi($res);
        }

        Misc::redirect('/profesores', [
            'email' => $res->data->email
        ]);
    }
}

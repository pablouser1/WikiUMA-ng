<?php
namespace App\Controllers;

use App\Api;
use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Items\Review;

class ProfesorController {
    static public function get() {
        if (isset($_GET['email'])) {
            self::byEmail();
        } else if (isset($_GET['idnc'])) {
            self::byIdnc();
        } else {
            ErrorHandler::show(400, "Parámetros inválidos");
        }
    }

    static private function byEmail() {
        if (!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
            ErrorHandler::show(400, 'Tienes que enviar una dirección de correo válida');
        }
        $email = $_GET['email'];
        $api = new Api;
        $profesor = $api->profesor($email);
        if ($profesor) {
            // Get reviews from db
            $reviewDb = new Review;
            $reviews = $reviewDb->getAllFromIdnc($profesor->idnc);
            $stats = $reviewDb->statsOne($profesor->idnc);

            Wrappers::plates('profesor', [
                'title' => $profesor->nombre,
                'profesor' => $profesor,
                'reviews' => $reviews,
                'stats' => $stats
            ]);
        }
    }

    /**
     * Tries to convert idnc request to email
     */
    static private function byIdnc() {
        $idnc = $_GET['idnc'];
        $api = new Api;
        $email = $api->profesorWeb($idnc);
        if ($email) {
            Misc::redirect('/profesores', [
                'email' => $email
            ]);
        } else {
            ErrorHandler::show(502, 'Error interno al procesar solicitud');
        }
    }
}

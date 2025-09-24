<?php

namespace App\Controllers;

use App\Api;
use App\Wrappers\MsgHandler;
use Laminas\Diactoros\Response;

/**
 * Centros controller
 */
class CentrosController extends Controller
{
    /**
     * Get all faculties.
     *
     * Route: `/centros`.
     */
    public static function index(): Response
    {
        $api = new Api();
        $centros = $api->centros();
        if (!$centros->success) {
            return MsgHandler::errorFromApi($centros);
        }

        return self::__render('views/centros', [
            'centros' => $centros->data,
        ]);
    }
}

<?php

namespace App\Controllers;

use App\Api;
use App\Wrappers\MsgHandler;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Centros controller.
 */
class CentrosController extends Controller
{
    /**
     * Get all faculties.
     *
     * - Route: `/centros`
     * - Method: `GET`
     */
    public static function index(ServerRequestInterface $request): Response
    {
        $api = new Api();
        $centros = $api->centros();
        if (!$centros->success) {
            return MsgHandler::errorFromApi($centros, $request);
        }

        return self::__render('views/centros', $request, [
            'centros' => $centros->data,
        ]);
    }
}

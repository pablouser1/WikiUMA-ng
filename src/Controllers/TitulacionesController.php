<?php

namespace App\Controllers;

use App\Api;
use App\Wrappers\MsgHandler;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

class TitulacionesController extends Controller
{
    public static function index(ServerRequestInterface $request, array $args): Response
    {
        $api = new Api();
        $titulaciones = $api->titulaciones($args['centro_id']);
        if (!$titulaciones->success) {
            return MsgHandler::errorFromApi($titulaciones, $request);
        }

        return self::__render('views/titulaciones', $request, [
            'titulaciones' => $titulaciones->data,
        ]);
    }
}

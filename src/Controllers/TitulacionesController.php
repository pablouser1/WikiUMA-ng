<?php

namespace App\Controllers;

use App\Api;
use App\Wrappers\MsgHandler;
use App\Wrappers\Plates;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class TitulacionesController
{
    public static function index(ServerRequestInterface $request, array $args)
    {
        $api = new Api();
        $titulaciones = $api->titulaciones($args['centro_id']);
        if (!$titulaciones->success) {
            return MsgHandler::errorFromApi($titulaciones);
        }
        return new HtmlResponse(Plates::render('views/titulaciones', ['titulaciones' => $titulaciones->data]));
    }
}

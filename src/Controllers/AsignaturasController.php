<?php
namespace App\Controllers;

use App\Api;
use App\Constants\Messages;
use App\Wrappers\Plates;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class AsignaturasController
{
    public static function index(ServerRequestInterface $request, array $args)
    {
        $api = new Api;
        $asignatura = $api->asignatura($args['asignatura_id'], $args['plan_id']);
        if (!$asignatura->success) {
            http_response_code(503);
            return new HtmlResponse(Plates::renderError(Messages::API_ERROR, $asignatura->error));
        }

        return new HtmlResponse(Plates::render('views/asignatura', ['asignatura' => $asignatura->data]));
    }
}

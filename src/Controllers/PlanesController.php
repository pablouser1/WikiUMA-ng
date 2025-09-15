<?php
namespace App\Controllers;

use App\Api;
use App\Constants\Messages;
use App\Wrappers\Plates;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class PlanesController
{
    public static function index(ServerRequestInterface $request, array $args)
    {
        $api = new Api;
        $plan_id = $args['plan_id'];
        $plan = $api->plan($plan_id);
        if (!$plan->success) {
            http_response_code(503);
            return new HtmlResponse(Plates::renderError(Messages::API_ERROR, $plan->error));
        }

        $cursos = [];
        foreach ($plan->data->asignaturas as $asignatura) {
            $cursos[intval($asignatura->curso)][] = $asignatura;
        }
        return new HtmlResponse(Plates::render('views/plan', [
            'plan_id' => $plan_id,
            'cursos' => $cursos,
        ]));
    }
}

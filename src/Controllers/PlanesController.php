<?php
namespace App\Controllers;

use App\Api;
use App\Wrappers\MsgHandler;
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
            return MsgHandler::errorFromApi($plan);
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

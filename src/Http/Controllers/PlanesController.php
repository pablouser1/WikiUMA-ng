<?php

namespace App\Http\Controllers;

use App\Wrappers\MsgHandler;
use App\Wrappers\UMA;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Planes Controller.
 */
class PlanesController extends Controller
{
    /**
     * Planes details.
     *
     * - Route: `/planes/{plan_id}`
     * - Method: `GET`
     */
    public static function index(ServerRequestInterface $request, array $args): Response
    {
        $api = UMA::api();
        $plan_id = $args['plan_id'];
        $plan = $api->plan($plan_id);
        if (!$plan->success) {
            return MsgHandler::errorFromApi($plan, $request);
        }

        $cursos = [];
        foreach ($plan->data->asignaturas as $asignatura) {
            $cursos[intval($asignatura->curso)][] = $asignatura;
        }

        return self::__render('views/plan', $request, [
            'plan_id' => $plan_id,
            'cursos' => $cursos,
        ]);
    }
}

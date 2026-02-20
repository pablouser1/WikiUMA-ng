<?php

namespace App\Http\Controllers;

use App\Wrappers\MsgHandler;
use App\Wrappers\UMA;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;
use UMA\Models\Titulacion;

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
        $centro_id = (int) $args['centro_id'];
        $titulacion_id = (int) $args['titulacion_id'];

        $plan = $api->plan($titulacion_id);
        if (!$plan->success) {
            return MsgHandler::errorFromApi($plan, $request);
        }

        $titulaciones = $api->titulaciones($centro_id);
        if (!$titulaciones->success) {
            return MsgHandler::errorFromApi($titulaciones, $request);
        }

        $titulacion = array_find($titulaciones->data, fn (Titulacion $titulacion) => $titulacion->codigoCentro === $centro_id && $titulacion->codigoPlan === $titulacion_id);
        $cursos = [];
        foreach ($plan->data->asignaturas as $asignatura) {
            $cursos[$asignatura->curso][] = $asignatura;
        }

        return self::__render('views/plan', $request, [
            'titulacion_id' => $titulacion_id,
            'titulacion' => $titulacion,
            'cursos' => $cursos,
        ]);
    }
}

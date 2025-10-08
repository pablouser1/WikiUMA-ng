<?php

namespace App\Controllers;

use App\Api;
use App\Cache;
use App\Enums\ReviewTypesEnum;
use App\Traits\HasReviews;
use App\Wrappers\MsgHandler;
use App\Wrappers\Misc;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Asignaturas Controller
 */
class AsignaturasController extends Controller
{
    use HasReviews;

    /**
     * Subject info.
     *
     * Route: `/planes/{plan_id}/asignaturas/{asignatura_id}`.
     *
     * @param array{"asignatura_id": int, "plan_id": int} $args
     */
    public static function index(ServerRequestInterface $request, array $args): Response
    {
        $api = new Api();
        $uri = $request->getUri();
        $query = $request->getQueryParams();

        $asignatura = $api->asignatura($args['asignatura_id'], $args['plan_id']);
        if (!$asignatura->success) {
            return MsgHandler::errorFromApi($asignatura);
        }

        $id = Misc::planAsignaturaJoin($args['plan_id'], $args['asignatura_id']);

        $filter = self::__getReviewFilter($query['filter'] ?? null);
        $reviews = self::__getReviews($id, ReviewTypesEnum::SUBJECT, $query['page'] ?? 1, $filter);
        $stats = self::__getStats($id, ReviewTypesEnum::SUBJECT);

        return self::__render('views/asignatura', [
            'asignatura' => $asignatura->data,
            'reviews' => $reviews,
            'stats' => $stats,
            'plan_id' => $args['plan_id'],
            'uri' => $uri,
            'query' => $query,
        ]);
    }
}

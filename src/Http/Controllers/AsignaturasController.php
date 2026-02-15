<?php

namespace App\Http\Controllers;

use App\Enums\ReviewTypesEnum;
use App\Traits\HasReviews;
use App\Wrappers\MsgHandler;
use App\Wrappers\Misc;
use App\Wrappers\UMA;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Asignaturas Controller.
 */
class AsignaturasController extends Controller
{
    use HasReviews;

    /**
     * Subject info.
     *
     * - Route: `/planes/{plan_id}/asignaturas/{asignatura_id}`
     * - Method: `GET`
     *
     * @param array{"asignatura_id": int, "plan_id": int} $args
     */
    public static function index(ServerRequestInterface $request, array $args): Response
    {
        $api = UMA::api();
        $query = $request->getQueryParams();

        $page = self::__parseIntFromQuery('page', $query);
        if ($page === null) {
            throw self::__invalidParams();
        }

        $asignatura = $api->asignatura($args['asignatura_id'], $args['plan_id']);
        if (!$asignatura->success) {
            return MsgHandler::errorFromApi($asignatura, $request);
        }

        $id = Misc::planAsignaturaJoin($args['plan_id'], $args['asignatura_id']);

        $filter = self::__getReviewFilter($query['filter'] ?? null);
        $reviews = self::__getReviews($id, ReviewTypesEnum::SUBJECT, $page, $filter);
        $stats = self::__getStats($id, ReviewTypesEnum::SUBJECT);

        return self::__render('views/asignatura', $request, [
            'asignatura' => $asignatura->data,
            'reviews' => $reviews,
            'stats' => $stats,
            'plan_id' => $args['plan_id'],
            'query' => $query,
        ]);
    }
}

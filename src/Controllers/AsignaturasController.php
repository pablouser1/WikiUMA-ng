<?php
namespace App\Controllers;

use App\Api;
use App\Enums\ReviewTypesEnum;
use App\Models\Review;
use App\Models\Tag;
use App\Wrappers\MsgHandler;
use App\Wrappers\Misc;
use App\Wrappers\Plates;
use App\Wrappers\Stats;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Asignaturas Controller
 */
class AsignaturasController
{
    /**
     * Subject info.
     *
     * Route: `/planes/{plan_id}/asignaturas/{asignatura_id}`.
     *
     * @param array{"asignatura_id": int, "plan_id": int} $args
     */
    public static function index(ServerRequestInterface $request, array $args): Response
    {
        $api = new Api;
        $asignatura = $api->asignatura($args['asignatura_id'], $args['plan_id']);
        if (!$asignatura->success) {
            return MsgHandler::errorFromApi($asignatura);
        }

        $id = Misc::planAsignaturaJoin($args['plan_id'], $args['asignatura_id']);

        $reviews = Review::where('target', '=', $id)
            ->where('type', '=', ReviewTypesEnum::SUBJECT)
            ->get();
        $stats = Stats::fromTarget($id, ReviewTypesEnum::SUBJECT);
        $tags = Tag::where('for', '=', ReviewTypesEnum::TEACHER)->get();

        return new HtmlResponse(Plates::render('views/asignatura', [
            'asignatura' => $asignatura->data,
            'reviews' => $reviews,
            'tags' => $tags,
            'stats' => $stats,
            'plan_id' => $args['plan_id'],
        ]));
    }
}

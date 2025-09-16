<?php
namespace App\Controllers;

use App\Api;
use App\Enums\ReviewTypesEnum;
use App\Models\Review;
use App\Wrappers\ErrorHandler;
use App\Wrappers\Misc;
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
            return ErrorHandler::showFromApiRes($asignatura);
        }

        $reviews = Review::where('target', '=', Misc::planAsignaturaJoin($args['plan_id'], $args['asignatura_id']))
            ->where('type', '=', ReviewTypesEnum::SUBJECT)
            ->get();

        return new HtmlResponse(Plates::render('views/asignatura', [
            'asignatura' => $asignatura->data,
            'reviews' => $reviews,
            'plan_id' => $args['plan_id'],
        ]));
    }
}

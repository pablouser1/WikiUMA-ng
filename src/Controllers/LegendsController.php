<?php

namespace App\Controllers;

use App\Enums\ReviewTypesEnum;
use App\Models\Legend;
use App\Traits\HasReviews;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Legends Controller.
 */
class LegendsController extends Controller
{
    use HasReviews;

    /**
     * Main site.
     *
     * Route: `/`
     * Method: `GET`
     */
    public static function index(ServerRequestInterface $request): Response
    {
        $legends = Legend::all();
        return self::__render('views/legends/index', $request, [
            'legends' => $legends,
        ]);
    }

    public static function show(ServerRequestInterface $request, array $args): Response
    {
        $query = $request->getQueryParams();
        $id = intval($args['legend_id']);

        $page = self::__parseIntFromQuery('page', $query);
        if ($page === null) {
            throw self::__invalidParams();
        }

        $legend = Legend::find($id);
        if ($legend === null) {
            throw self::__invalidParams();
        }

        $filter = self::__getReviewFilter($query['filter'] ?? null);
        $reviews = self::__getReviews($legend->id, ReviewTypesEnum::LEGEND, $page, $filter);
        $stats = self::__getStats($legend->id, ReviewTypesEnum::LEGEND);

        return self::__render('views/legends/single', $request, [
            'legend' => $legend,
            'reviews' => $reviews,
            'stats' => $stats,
            'query' => $query,
        ]);
    }
}

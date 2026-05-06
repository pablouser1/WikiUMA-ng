<?php

namespace App\Http\Controllers;

use App\Enums\HallRangeEnum;
use App\Wrappers\Env;
use App\Wrappers\MsgHandler;
use App\Wrappers\Stats;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Hall of Fame Controller
 */
class HallController extends Controller
{
    /**
     * List teacher with best score.
     *
     * - Route: `/hall`
     * - Method: `GET`
     */
    public static function index(ServerRequestInterface $request): Response
    {
        $query = $request->getQueryParams();

        $best = true;
        $lowest = Env::app_lowest();
        if ($lowest && ($query[$lowest[0]] ?? null) === $lowest[1]) {
            $best = false;
        }

        $range = HallRangeEnum::tryFrom($query['range'] ?? '') ?? HallRangeEnum::ALL_TIMES;
        $hall = Stats::weighted(
            best: $best,
            within: $range->carbon(),
        );
        if ($hall->lastRes !== null && !$hall->lastRes->success) {
            return MsgHandler::errorFromApi($hall->lastRes, $request);
        }

        return self::__render('views/hall', $request, [
            'hall' => $hall->data,
            'ranges' => HallRangeEnum::cases(),
            'currentRange' => $range,
            'query' => $query,
        ]);
    }
}

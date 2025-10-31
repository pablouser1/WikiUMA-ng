<?php

namespace App\Controllers;

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
        $hall = Stats::hallOfFame();
        if (!$hall->lastRes->success) {
            return MsgHandler::errorFromApi($hall->lastRes, $request);
        }

        return self::__render('views/hall', $request, [
            'hall' => $hall->data,
        ]);
    }
}

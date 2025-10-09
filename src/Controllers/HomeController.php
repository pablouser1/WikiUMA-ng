<?php

namespace App\Controllers;

use App\Wrappers\Stats;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Home Controller.
 */
class HomeController extends Controller
{
    /**
     * Main site.
     *
     * Route: `/`
     * Method: `GET`
     */
    public static function index(ServerRequestInterface $request): Response
    {
        $stats = Stats::all();
        return self::__render('views/home', $request, [
            'stats' => $stats,
        ]);
    }
}

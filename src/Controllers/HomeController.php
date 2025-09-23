<?php

namespace App\Controllers;

use App\Wrappers\Stats;
use Laminas\Diactoros\Response;

/**
 * Home Controller.
 */
class HomeController extends Controller
{
    /**
     * Main site.
     *
     * Route: `/`.
     */
    public static function index(): Response
    {
        $stats = Stats::all();
        return self::__render('views/home', [
            'stats' => $stats,
        ]);
    }
}

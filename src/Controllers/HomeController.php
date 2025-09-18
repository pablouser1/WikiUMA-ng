<?php
namespace App\Controllers;

use App\Wrappers\Plates;
use App\Wrappers\Stats;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;

/**
 * Home Controller.
 */
class HomeController
{
    /**
     * Main site.
     *
     * Route: `/`.
     */
    public static function index(): Response
    {
        $stats = Stats::all();
        return new HtmlResponse(Plates::render('views/home', ['stats' => $stats]));
    }
}

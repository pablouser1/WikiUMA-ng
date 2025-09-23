<?php

namespace App\Controllers;

use Laminas\Diactoros\Response;

/**
 * Misc Controller. Used for read-only, static pages.
 */
class MiscController extends Controller
{
    /**
     * About site, with info about the site and external libraries.
     *
     * Route: `/about`.
     */
    public static function about(): Response
    {
        return self::__render('views/about');
    }

    /**
     * Legal site, with info about terms and conditions.
     *
     * Route: `/legal`.
     */
    public static function legal(): Response
    {
        return self::__render('views/legal');
    }
}

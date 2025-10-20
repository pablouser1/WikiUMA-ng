<?php

namespace App\Controllers;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Misc Controller. Used for read-only, static pages.
 */
class MiscController extends Controller
{
    /**
     * About site, with info about the site and external libraries.
     *
     * - Route: `/about`
     * - Method: `GET`
     */
    public static function about(ServerRequestInterface $request): Response
    {
        return self::__render('views/about', $request);
    }

    /**
     * Legal site, with info about terms and conditions.
     *
     * - Route: `/legal`
     * - Method: `GET`
     */
    public static function legal(ServerRequestInterface $request): Response
    {
        return self::__render('views/legal', $request);
    }

    public static function contact(ServerRequestInterface $request): Response
    {
        return self::__render('views/contact', $request);
    }
}

<?php

namespace App\Http\Controllers;

use App\Wrappers\Env;
use App\Wrappers\MsgHandler;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
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

    public static function maintenance(ServerRequestInterface $request): Response
    {
        if (!Env::app_maintenance()) {
            return new RedirectResponse('/');
        }

        return MsgHandler::error(503, 'Mantenimiento', 'WikiUMA está en mantenimiento', $request);
    }
}

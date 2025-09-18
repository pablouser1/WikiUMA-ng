<?php
namespace App\Controllers;

use App\Wrappers\Plates;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;

/**
 * Misc Controller. Used for read-only, static pages.
 */
class MiscController
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

    private static function __render(string $template): HtmlResponse
    {
        return new HtmlResponse(Plates::render($template));
    }
}

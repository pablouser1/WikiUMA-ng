<?php

namespace App\Controllers;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Tips Controller.
 */
class TipsController extends Controller
{
    /**
     * Main site.
     *
     * Route: `/tips`
     * Method: `GET`
     */
    public static function index(ServerRequestInterface $request): Response
    {
        return self::__render('views/tips/index', $request);
    }

    /**
     * Email site.
     *
     * Route: `/tips/email`
     * Method: `GET`
     */
    public static function email(ServerRequestInterface $request): Response
    {
        return self::__render('views/tips/email', $request);
    }
}

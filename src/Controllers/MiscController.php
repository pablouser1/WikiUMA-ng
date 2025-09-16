<?php
namespace App\Controllers;

use App\Wrappers\Plates;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class MiscController
{
    public static function home(ServerRequestInterface $request): Response
    {
        return self::__render('views/home');
    }

    public static function about(ServerRequestInterface $request): Response
    {
        return self::__render('views/about');
    }

    public static function legal(ServerRequestInterface $request): Response
    {
        return self::__render('views/legal');
    }

    private static function __render(string $template): HtmlResponse
    {
        return new HtmlResponse(Plates::render($template));
    }
}

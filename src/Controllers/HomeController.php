<?php
namespace App\Controllers;

use App\Wrappers\Plates;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class HomeController
{
    public static function index(ServerRequestInterface $request)
    {
        return new HtmlResponse(Plates::render('views/home'));
    }
}

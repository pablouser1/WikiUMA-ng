<?php
namespace App\Controllers;

use App\Api;
use App\Wrappers\ErrorHandler;
use App\Wrappers\Plates;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class CentrosController
{
    public static function index(ServerRequestInterface $request)
    {
        $api = new Api;
        $centros = $api->centros();
        if (!$centros->success) {
            return ErrorHandler::showFromApiRes($centros);
        }

        return new HtmlResponse(Plates::render('views/centros', ['centros' => $centros->data]));
    }
}

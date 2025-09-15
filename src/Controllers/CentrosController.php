<?php
namespace App\Controllers;

use App\Api;
use App\Constants\Messages;
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
            http_response_code(503);
            return new HtmlResponse(Plates::renderError(Messages::API_ERROR, $centros->error));
        }
        return new HtmlResponse(Plates::render('views/centros', ['centros' => $centros->data]));
    }
}

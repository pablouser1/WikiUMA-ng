<?php
namespace App\Controllers;

use App\Api;
use App\Constants\Messages;
use App\Wrappers\Plates;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class SearchController {
    public static function index(ServerRequestInterface $request): Response {
        $query = $request->getQueryParams();
        $nombre = $query['nombre'] ?? '';
        $apellido_1 = $query['apellido_1'] ?? '';
        $apellido_2 = $query['apellido_2'] ?? '';

        $api = new Api;

        $res = $api->buscar($nombre, $apellido_1, $apellido_2);

        if (!$res->success) {
            return new HtmlResponse(Plates::renderError(Messages::API_ERROR, $res->error));
        }

        return new HtmlResponse(Plates::render('views/search', [
            'results' => $res->data,
        ]));
    }
}

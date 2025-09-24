<?php

namespace App\Controllers;

use App\Api;
use App\Wrappers\MsgHandler;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

class SearchController extends Controller
{
    public static function index(ServerRequestInterface $request): Response
    {
        $query = $request->getQueryParams();
        $nombre = $query['nombre'] ?? '';
        $apellido_1 = $query['apellido_1'] ?? '';
        $apellido_2 = $query['apellido_2'] ?? '';

        $api = new Api();

        $search = $api->buscar($nombre, $apellido_1, $apellido_2);

        if (!$search->success) {
            return MsgHandler::errorFromApi($search);
        }

        return self::__render('views/search', [
            'results' => $search->data,
        ]);
    }
}

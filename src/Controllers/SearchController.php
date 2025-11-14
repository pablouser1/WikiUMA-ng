<?php

namespace App\Controllers;

use App\Api;
use App\Constants\Extras;
use App\Wrappers\MsgHandler;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;

class SearchController extends Controller
{
    public static function index(ServerRequestInterface $request): Response
    {
        $query = $request->getQueryParams();
        $nombre = $query['nombre'] ?? '';
        $apellido_1 = $query['apellido_1'] ?? '';
        $apellido_2 = $query['apellido_2'] ?? '';

        if ($nombre === '' && $apellido_1 === '' && $apellido_2 === '') {
            throw self::__invalidParams();
        }

        $url = Extras::search($query);
        if ($url !== null) {
            return new RedirectResponse($url);
        }

        $api = new Api();

        $search = $api->buscar($nombre, $apellido_1, $apellido_2);

        if (!$search->success) {
            return MsgHandler::errorFromApi($search, $request);
        }

        return self::__render('views/search', $request, [
            'results' => $search->data,
        ]);
    }
}

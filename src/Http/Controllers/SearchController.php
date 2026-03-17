<?php

namespace App\Http\Controllers;

use App\Constants\Extras;
use App\Wrappers\MsgHandler;
use App\Wrappers\UMA;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;
use UMA\Models\SearchResult;

class SearchController extends Controller
{
    public static function index(ServerRequestInterface $request): Response
    {
        return self::__render('views/search/index', $request);
    }

    public static function results(ServerRequestInterface $request): Response
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

        $api = UMA::api();

        $search = $api->buscar($nombre, $apellido_1, $apellido_2);
        if (!$search->success) {
            return MsgHandler::errorFromApi($search, $request);
        }

        // Filter excluded idncs
        $results = array_filter($search->data, fn(SearchResult $result) => !UMA::isExcluded($result->idnc));

        return self::__render('views/search/results', $request, [
            'results' => $results,
        ]);
    }
}

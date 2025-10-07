<?php

namespace App\Controllers;

use App\Api;
use App\Cache;
use App\Enums\ReviewTypesEnum;
use App\Traits\HasReviews;
use App\Wrappers\Env;
use App\Wrappers\MsgHandler;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

class ProfesoresController extends Controller
{
    use HasReviews;

    public static function index(ServerRequestInterface $request): Response
    {
        $uri = $request->getUri();
        $query = $request->getQueryParams();
        $cache = new Cache();
        $api = new Api($cache);

        $response = null;
        if (isset($query['email'])) {
            $response = self::__byEmail($query['email'], $api, $uri, $query, $cache);
        } elseif (isset($query['idnc'])) {
            $response = self::__byIdnc($query['idnc'], $api);
        } else {
            throw self::__invalidParams();
        }

        return $response;
    }

    private static function __byEmail(string $email, Api $api, UriInterface $uri, array $query, Cache $cache): Response
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw self::__invalidParams();
        }

        $profesor = $api->profesor($email);
        if (!$profesor->success) {
            return MsgHandler::errorFromApi($profesor);
        }

        $filter = self::__getFilter($query['filter'] ?? null);
        $reviews = self::__getReviews($profesor->data->idnc, ReviewTypesEnum::TEACHER, $query['page'] ?? 1, $filter);
        $stats = self::__getStats($profesor->data->idnc, ReviewTypesEnum::TEACHER, $cache);

        return self::__render('views/profesor', [
            'profesor' => $profesor->data,
            'reviews' => $reviews,
            'stats' => $stats,
            'uri' => $uri,
            'query' => $query,
        ]);
    }

    private static function __byIdnc(string $idnc, Api $api): Response
    {
        $profesor = $api->profesorWeb($idnc);
        if (!$profesor->success) {
            throw self::__invalidParams();
        }

        return new RedirectResponse(Env::app_url('/profesores', [
            'email' => $profesor->data->email,
        ]));
    }
}

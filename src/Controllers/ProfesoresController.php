<?php

namespace App\Controllers;

use App\Api;
use App\Constants\Messages;
use App\Enums\ReviewTypesEnum;
use App\Traits\HasReviews;
use App\Wrappers\Env;
use App\Wrappers\MsgHandler;
use App\Wrappers\Plates;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use League\Route\Http\Exception\BadRequestException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

class ProfesoresController
{
    use HasReviews;

    public static function index(ServerRequestInterface $request): Response
    {
        $uri = $request->getUri();
        $query = $request->getQueryParams();
        $api = new Api();

        $response = null;
        if (isset($query['email'])) {
            $response = self::__byEmail($query['email'], $api, $uri, $query);
        } elseif (isset($query['idnc'])) {
            $response = self::__byIdnc($query['idnc'], $api);
        } else {
            $response = self::__invalidParams();
        }

        return $response;
    }

    private static function __byEmail(string $email, Api $api, UriInterface $uri, array $query): Response
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
        $stats = self::__getStats($profesor->data->idnc, ReviewTypesEnum::TEACHER);
        $tags = self::__getTags(ReviewTypesEnum::TEACHER);

        return new HtmlResponse(Plates::render('views/profesor', [
            'profesor' => $profesor->data,
            'reviews' => $reviews,
            'stats' => $stats,
            'tags' => $tags,
            'uri' => $uri,
            'query' => $query,
        ]));
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

    private static function __invalidParams(): BadRequestException
    {
        return new BadRequestException(Messages::MUST_SEND_PARAMS);
    }
}

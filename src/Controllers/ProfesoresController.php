<?php

namespace App\Controllers;

use App\Api;
use App\Enums\ReviewTypesEnum;
use App\Traits\HasReviews;
use App\Wrappers\Crypto;
use App\Wrappers\Env;
use App\Wrappers\MsgHandler;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;

class ProfesoresController extends Controller
{
    use HasReviews;

    public static function index(ServerRequestInterface $request): Response
    {
        $query = $request->getQueryParams();
        $api = new Api();

        $response = null;
        if (isset($query['email'])) {
            $response = self::__byEmail($query['email'], $api, $request, $query);
        } elseif (isset($query['idnc'])) {
            $response = self::__byIdnc($query['idnc'], $api);
        } else {
            throw self::__invalidParams();
        }

        return $response;
    }

    private static function __byEmail(string $emailEncrypted, Api $api, ServerRequestInterface $request, array $query): Response
    {
        $email = Crypto::decrypt($emailEncrypted);
        if ($email === null) {
            throw self::__invalidParams();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw self::__invalidParams();
        }

        $profesor = $api->profesor($email);
        if (!$profesor->success) {
            return MsgHandler::errorFromApi($profesor, $request);
        }

        $filter = self::__getReviewFilter($query['filter'] ?? null);
        $reviews = self::__getReviews($profesor->data->idnc, ReviewTypesEnum::TEACHER, $query['page'] ?? 1, $filter);
        $stats = self::__getStats($profesor->data->idnc, ReviewTypesEnum::TEACHER);

        return self::__render('views/profesor', $request, [
            'profesor' => $profesor->data,
            'reviews' => $reviews,
            'stats' => $stats,
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
            'email' => Crypto::encrypt($profesor->data->email),
        ]));
    }
}

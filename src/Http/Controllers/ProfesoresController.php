<?php

namespace App\Http\Controllers;

use App\Enums\ReviewTypesEnum;
use App\Traits\HasReviews;
use App\Wrappers\Env;
use App\Wrappers\MsgHandler;
use App\Wrappers\Security;
use App\Wrappers\UMA;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;
use UMA\Api;

/**
 * Teachers Controller.
 */
class ProfesoresController extends Controller
{
    use HasReviews;

    /**
     * Get teacher info.
     *
     * - Route: `/profesores`
     * - Method: `GET`
     * - Query: email OR idnc
     */
    public static function index(ServerRequestInterface $request): Response
    {
        $query = $request->getQueryParams();
        $api = UMA::api();

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
        $email = Security::decrypt($emailEncrypted);
        if ($email === null) {
            throw self::__invalidParams();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw self::__invalidParams();
        }

        $page = self::__parseIntFromQuery('page', $query);
        if ($page === null) {
            throw self::__invalidParams();
        }

        $profesor = $api->profesor($email);
        if (!$profesor->success) {
            return MsgHandler::errorFromApi($profesor, $request);
        }

        $filter = self::__getReviewFilter($query['filter'] ?? null);
        $reviews = self::__getReviews($profesor->data->idnc, ReviewTypesEnum::TEACHER, $page, $filter);
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
            'email' => Security::encrypt($profesor->data),
        ]));
    }
}

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
use UMA\Models\Profesor;

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

        if (isset($query['email'])) {
            return self::__byEmail($query['email'], $request, $query);
        }

        if (isset($query['idnc'])) {
            return self::__byIdnc($query['idnc']);
        }

        throw self::__invalidParams();
    }

    public static function stats(ServerRequestInterface $request): Response
    {
        $query = $request->getQueryParams();
        $resolved = self::__resolveProfesor($query['email'] ?? null, $request);

        // If the resolver returned a Response (error), return it immediately
        if ($resolved instanceof Response) {
            return $resolved;
        }

        return self::__render('views/profesor/stats', $request, [
            'profesor' => $resolved,
        ]);
    }

    private static function __byEmail(string $emailRaw, ServerRequestInterface $request, array $query): Response
    {
        // Redirect if raw email is provided
        if (filter_var($emailRaw, FILTER_VALIDATE_EMAIL)) {
            return new RedirectResponse(Env::app_url('/profesores', [
                'email' => Security::encrypt($emailRaw),
            ]));
        }

        $resolved = self::__resolveProfesor($emailRaw, $request);
        if ($resolved instanceof Response) {
            return $resolved;
        }

        $page = self::__parseIntFromQuery('page', $query);
        if ($page === null) {
            throw self::__invalidParams();
        }

        $filter = self::__getReviewFilter($query['filter'] ?? null);

        return self::__render('views/profesor/index', $request, [
            'profesor' => $resolved,
            'reviews' => self::__getReviews($resolved->idnc, ReviewTypesEnum::TEACHER, $page, $filter),
            'stats' => self::__getStats($resolved->idnc, ReviewTypesEnum::TEACHER),
            'query' => $query,
        ]);
    }

    private static function __byIdnc(string $idnc): Response
    {
        if (UMA::isExcluded($idnc)) {
            throw self::__invalidParams();
        }

        $profesor = UMA::api()->profesorWeb($idnc);
        if (!$profesor->success) {
            throw self::__invalidParams();
        }

        return new RedirectResponse(Env::app_url('/profesores', [
            'email' => Security::encrypt($profesor->data),
        ]));
    }

    private static function __resolveProfesor(?string $encryptedEmail, ServerRequestInterface $request): Profesor|Response
    {
        if (!$encryptedEmail) {
            throw self::__invalidParams();
        }

        $email = Security::decrypt($encryptedEmail);
        if ($email === null || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw self::__invalidEmail();
        }

        $profesor = UMA::api()->profesor($email);

        if (!$profesor->success) {
            return MsgHandler::errorFromApi($profesor, $request);
        }

        if (UMA::isExcluded($profesor->data->idnc)) {
            throw self::__invalidEmail();
        }

        return $profesor->data;
    }
}

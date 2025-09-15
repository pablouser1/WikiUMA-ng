<?php
namespace App\Controllers;

use App\Api;
use App\Constants\Messages;
use App\Enums\ReviewTypesEnum;
use App\Models\Review;
use App\Wrappers\Env;
use App\Wrappers\Misc;
use App\Wrappers\Plates;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;

class ProfesoresController
{
    public static function index(ServerRequestInterface $request)
    {
        $query = $request->getQueryParams();
        $api = new Api;

        $response = null;
        if (isset($query['email'])) {
            $response = self::__byEmail($query['email'], $api);
        } else if (isset($query['idnc'])) {
            $response = self::__byIdnc($query['idnc'], $api);
        } else {
            http_response_code(400);
            $response = new HtmlResponse(Plates::renderError(Messages::INVALID_REQUEST, Messages::MUST_SEND_ID));
        }

        return $response;
    }

    private static function __byEmail(string $email, Api $api): Response
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            return new HtmlResponse(Plates::renderError(Messages::CLIENT_ERROR, Messages::MUST_SEND_VALID_EMAIL));
        }

        $profesor = $api->profesor($email);
        if (!$profesor->success) {
            return new HtmlResponse(Plates::renderError(Messages::API_ERROR, $profesor->error));
        }

        $reviews = Review::where('target', '=', $profesor->data->idnc)->where('type', '=', ReviewTypesEnum::TEACHER)->get();

        return new HtmlResponse(Plates::render('views/profesor', [
            'profesor' => $profesor->data,
            'reviews' => $reviews,
        ]));
    }

    private static function __byIdnc(string $idnc, Api $api): Response
    {
        $profesor = $api->profesorWeb($idnc);
        if (!$profesor->success) {
            return new HtmlResponse(Plates::renderError(Messages::API_ERROR, $profesor->error));
        }

        return new RedirectResponse(Env::app_url('/profesores', [
            'email' => $profesor->data->email,
        ]));
    }
}

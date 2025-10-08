<?php

namespace App\Controllers;

use App\Constants\Messages;
use App\Models\User;
use App\Wrappers\Env;
use App\Wrappers\Session;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use League\Route\Http\Exception\BadRequestException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Auth Controller.
 */
class AuthController extends Controller
{
    /**
     * Login form.
     *
     * Route: `/staff/login`.
     */
    public static function index(): Response
    {
        return self::__render('views/staff/login');
    }

    /**
     * Login POST.
     *
     * Route: `/staff/login`.
     */
    public static function post(ServerRequestInterface $request): Response
    {
        $body = $request->getParsedBody();

        if (!isset($body['username'], $body['password'])) {
            throw self::__invalidBody();
        }

        $username = trim($body['username']);
        $password = trim($body['password']);

        /** @var User */
        $user = User::where('username', '=', $username)->first();

        if ($user === null) {
            throw new BadRequestException(Messages::LOGIN_FAILED);
        }

        if (!$user->checkPassword($password)) {
            throw new BadRequestException(Messages::LOGIN_FAILED);
        }

        Session::login($user->username);

        return new RedirectResponse(Env::app_url('/'));
    }

    public static function logout(ServerRequestInterface $request): Response
    {
        Session::destroy();
        return new RedirectResponse(Env::app_url('/'));
    }
}

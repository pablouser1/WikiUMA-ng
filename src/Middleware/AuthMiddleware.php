<?php

namespace App\Middleware;

use App\Wrappers\Env;
use App\Wrappers\Session;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Check if admin is logged in before entering restricted routes.
 */
class AuthMiddleware implements MiddlewareInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        Session::start();
        $path = $request->getUri()->getPath();

        if (!str_starts_with($path, '/staff/login') && !Session::isLoggedIn()) {
            return new RedirectResponse(Env::app_url('/staff/login'));
        }

        return $handler->handle($request);
    }
}

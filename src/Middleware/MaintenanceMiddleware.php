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
 * Check if app is in maintenance mode and redirect to page
 */
class MaintenanceMiddleware implements MiddlewareInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();

        if (!str_starts_with($path, '/maintenance') && Env::app_maintenance()) {
            return new RedirectResponse(Env::app_url('/maintenance'));
        }

        return $handler->handle($request);
    }
}

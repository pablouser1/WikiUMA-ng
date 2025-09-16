<?php

namespace App\Controllers;

use App\Wrappers\Env;
use App\Wrappers\ErrorHandler;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;

class DevController
{
    public static function reactions(ServerRequestInterface $request, array $args): Response
    {
        if (!(isset($args['code']))) {
            return new RedirectResponse(Env::app_url('/'));
        }

        $code = intval($args['code']);

        return ErrorHandler::show($code, "Error $code", 'Example body');
    }
}

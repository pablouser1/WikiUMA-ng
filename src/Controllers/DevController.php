<?php

namespace App\Controllers;

use App\Wrappers\MsgHandler;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Dev Controller. Only active when APP_DEBUG=true
 */
class DevController extends Controller
{
    /**
     * Emulate an error.
     *
     * Route: `/dev/reactions/{code}`.
     *
     * @param array{"code": int} $args
     */
    public static function reactions(ServerRequestInterface $request, array $args): Response
    {
        $code = intval($args['code']);
        return MsgHandler::error($code, "Error $code", 'Example body');
    }
}

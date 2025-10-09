<?php

namespace App\Controllers;

use App\Enums\ReviewTypesEnum;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use League\Route\Http\Exception\BadRequestException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Redirect Controller.
 */
class RedirectController extends Controller
{
    /**
     * Redirect by type value.
     *
     * - Route: `/redirect`
     * - Method: `GET`
     */
    public static function index(ServerRequestInterface $request): Response
    {
        $query = $request->getQueryParams();

        if (!(isset($query['target'], $query['type']) && is_numeric($query['type']))) {
            throw self::__invalidParams();
        }

        $target = $query['target'];
        $typeInt = intval($query['type']);
        $type = ReviewTypesEnum::tryFrom($typeInt);

        if ($type === null) {
            throw self::__invalidParams();
        }

        $url = $type->url($target);
        if ($url === null) {
            throw new BadRequestException();
        }

        return new RedirectResponse($url);
    }
}

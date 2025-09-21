<?php

namespace App\Controllers;

use App\Constants\Messages;
use App\Enums\ReviewTypesEnum;
use Laminas\Diactoros\Response\RedirectResponse;
use League\Route\Http\Exception\BadRequestException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Redirect Controller.
 */
class RedirectController
{
    /**
     * Redirect by type value.
     *
     * Route: `/redirect`.
     */
    public static function index(ServerRequestInterface $request): RedirectResponse
    {
        $query = $request->getQueryParams();

        if (!(isset($query['target'], $query['type']) && is_numeric($query['type']))) {
            throw new BadRequestException(Messages::MUST_SEND_PARAMS);
        }

        $target = $query['target'];
        $typeInt = intval($query['type']);
        $type = ReviewTypesEnum::tryFrom($typeInt);

        if ($type === null) {
            throw new BadRequestException(Messages::MUST_SEND_PARAMS);
        }

        $url = $type->url($target);
        if ($url === null) {
            throw new BadRequestException();
        }

        return new RedirectResponse($url);
    }
}

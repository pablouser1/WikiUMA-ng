<?php

namespace App\Wrappers;

use App\Constants\Messages;
use App\Constants\Reactions;
use UMA\Models\Response as ApiResponse;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class MsgHandler
{
    public static function show(int $code, string $title, string $body, ServerRequestInterface $request, ?string $back = null, ?object $reaction = null): Response
    {
        return new HtmlResponse(
            Render::plates('views/message', [
                'title' => $title,
                'body' => $body,
                'back' => $back,
                'reaction' => $reaction,
                'uri' => $request->getUri(),
            ]),
            $code,
        );
    }

    public static function error(int $code, string $title, string $body, ServerRequestInterface $request): Response
    {
        $reaction = Reactions::random($code);
        return self::show($code, $title, $body, $request, null, $reaction);
    }

    public static function errorFromApi(ApiResponse $response, ServerRequestInterface $request): Response
    {
        return self::error(502, Messages::API_ERROR, $response->error, $request);
    }
}

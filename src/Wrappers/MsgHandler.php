<?php

namespace App\Wrappers;

use App\Constants\Messages;
use App\Constants\Reactions;
use App\Models\Api\Response as ApiResponse;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;

class MsgHandler
{
    public static function show(int $code, string $title, string $body, ?string $back = null, ?object $reaction = null): Response
    {
        return new HtmlResponse(
            Plates::render('views/message', [
                'title' => $title,
                'body' => $body,
                'back' => $back,
                'reaction' => $reaction,
            ]),
            $code,
        );
    }

    public static function error(int $code, string $title, string $body): Response
    {
        $reaction = Reactions::random($code);
        return self::show($code, $title, $body, null, $reaction);
    }

    public static function errorFromApi(ApiResponse $response): Response
    {
        return self::error(502, Messages::API_ERROR, $response->error);
    }
}

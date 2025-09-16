<?php

namespace App\Wrappers;

use App\Constants\Messages;
use App\Models\Api\Response as ApiResponse;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;

class ErrorHandler
{
    public static function show(int $code, string $title, string $body): Response
    {
        return new HtmlResponse(
            Plates::render('views/error', [
                'title' => $title,
                'body' => $body,
            ]),
            $code,
        );
    }

    public static function showFromApiRes(ApiResponse $response): Response
    {
        return self::show($response->code, Messages::API_ERROR, $response->error);
    }
}

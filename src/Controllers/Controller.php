<?php

namespace App\Controllers;

use App\Constants\Messages;
use App\Wrappers\Plates;
use Laminas\Diactoros\Response\HtmlResponse;
use League\Route\Http\Exception\BadRequestException;

abstract class Controller
{
    protected static function __invalidParams(): BadRequestException
    {
        return new BadRequestException(Messages::MUST_SEND_PARAMS);
    }

    protected static function __invalidBody(): BadRequestException
    {
        return new BadRequestException(Messages::MUST_SEND_BODY);
    }

    protected static function __tooManyChars(): BadRequestException
    {
        return new BadRequestException(Messages::TOO_MANY_CHARACTERS);
    }

    protected static function __render(string $template, array $data = []): HtmlResponse
    {
        return new HtmlResponse(Plates::render($template, $data));
    }
}

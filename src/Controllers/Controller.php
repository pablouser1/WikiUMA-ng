<?php

namespace App\Controllers;

use App\Constants\Messages;
use App\Wrappers\Plates;
use App\Wrappers\Security;
use Laminas\Diactoros\Response\HtmlResponse;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\UnauthorizedException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Common class for all controllers.
 */
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

    protected static function __invalidCaptcha(): UnauthorizedException
    {
        return new UnauthorizedException(Messages::INVALID_CAPTCHA);
    }

    protected static function __tooManyChars(): BadRequestException
    {
        return new BadRequestException(Messages::TOO_MANY_CHARACTERS);
    }

    protected static function __runCaptcha(string $token, array $serverParams): void
    {
        $captcha = Security::captcha($token);
        if (!$captcha->success) {
            logger()->error('Captcha failed', [
                'client_ip' => $serverParams['REMOTE_ADDR'],
                'errors' => $captcha->{'error-codes'},
            ]);

            throw self::__invalidCaptcha();
        }
    }

    protected static function __render(string $template, ServerRequestInterface $request, array $data = []): HtmlResponse
    {
        return new HtmlResponse(Plates::render($template, [
            ...$data,
            'uri' => $request->getUri(),
        ]));
    }
}

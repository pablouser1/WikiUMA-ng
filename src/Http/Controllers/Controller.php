<?php

namespace App\Http\Controllers;

use App\Constants\Messages;
use App\Wrappers\Render;
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

    protected static function __invalidEmail(): BadRequestException
    {
        return new BadRequestException(Messages::INVALID_EMAIL);
    }

    protected static function __invalidBody(): BadRequestException
    {
        return new BadRequestException(Messages::MUST_SEND_BODY);
    }

    protected static function __inconsistentData(): BadRequestException
    {
        return new BadRequestException(Messages::INCONSISTENT_DATA);
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
        $client_ip = $serverParams['REMOTE_ADDR'];
        $captcha = Security::captcha($token, $client_ip);
        if (!$captcha->success) {
            logger()->error('Captcha failed', [
                'client_ip' => $client_ip,
                'errors' => $captcha->{'error-codes'},
            ]);

            throw self::__invalidCaptcha();
        }
    }

    protected static function __render(string $template, ServerRequestInterface $request, array $data = []): HtmlResponse
    {
        return new HtmlResponse(Render::plates($template, [
            ...$data,
            'uri' => $request->getUri(),
        ]));
    }

    protected static function __parseIntFromQuery(string $key, array $query, ?int $default = 1): ?int
    {
        $valStr = $query[$key] ?? null;
        if ($valStr === null) {
            return $default;
        }

        if (!is_numeric($valStr)) {
            return null;
        }

        return intval($valStr);
    }
}

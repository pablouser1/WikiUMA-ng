<?php
namespace App\Controllers;

use AltchaOrg\Altcha\Altcha;
use App\Constants\Messages;
use App\Enums\ReviewTypesEnum;
use App\Models\Review;
use App\Wrappers\Env;
use App\Wrappers\Plates;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ServerRequestInterface;

class ReviewsController
{
    public static function create(ServerRequestInterface $request)
    {
        $body = $request->getParsedBody();
        if (!($body !== null && isset($body['target'], $body['type'], $body['message'], $body['note'], $body['altcha']) && is_numeric($body['note']))) {
            return self::__invalidBody();
        }

        $type = ReviewTypesEnum::tryFrom($body['type']);
        if ($type === null) {
            return self::__invalidBody();
        }

        // Check captcha first
        $altcha = new Altcha(Env::app_key());
        if (!$altcha->verifySolution($body['altcha'], true)) {
            return self::__invalidBody();
        }

        // Captcha is OK from now on
        $target = $body['target'];
        $msg = htmlspecialchars(trim($body['message']), ENT_QUOTES, 'UTF-8');
        $note = intval($body['note']);
        // Optional
        $username = $body['username'] ?? null;

        // TODO: Handle tags
        $tags = $body['tags'] ?? null;

        $review = new Review([
            'type' => $type,
            'target' => $target,
            'message' => $msg,
            'note' => $note,
            'username' => $username,
        ]);
        $review->save();

        return match ($type) {
            ReviewTypesEnum::TEACHER => new RedirectResponse(Env::app_url('/profesores', ['idnc' => $target])),
            ReviewTypesEnum::SUBJECT => new RedirectResponse(Env::app_url('/')),
            default => new RedirectResponse(Env::app_url('/')),
        };
    }

    private static function __invalidBody(): Response
    {
        return new HtmlResponse(Plates::renderError(Messages::CLIENT_ERROR, Messages::MUST_SEND_BODY));
    }
}

<?php
namespace App\Controllers;

use AltchaOrg\Altcha\Altcha;
use App\Constants\Messages;
use App\Enums\ReviewTypesEnum;
use App\Models\Review;
use App\Wrappers\Env;
use App\Wrappers\ErrorHandler;
use App\Wrappers\Misc;
use App\Wrappers\Profanity;
use Laminas\Diactoros\Response;
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
        $msg = Profanity::filter(htmlspecialchars(trim($body['message']), ENT_COMPAT));
        $note = intval($body['note']);
        // Optional
        $username = '';
        if (isset($body['username']) && !empty($body['username'])) {
            $username = Profanity::filter(htmlspecialchars(trim($body['username']), ENT_COMPAT));
        }

        $tags = isset($body['tags']) && is_array($body['tags']) ? $body['tags'] : null;

        $review = new Review([
            'type' => $type,
            'target' => $target,
            'message' => $msg,
            'note' => $note,
            'username' => $username,
        ]);
        $review->save();

        if ($tags !== null) {
            $review->tags()->attach($tags);
        }

        if ($type === ReviewTypesEnum::TEACHER) {
            return new RedirectResponse(Env::app_url('/profesores', ['idnc' => $target]));
        } else if ($type === ReviewTypesEnum::SUBJECT) {
            $arr = Misc::planAsignaturaSplit($target);
            return new RedirectResponse(Env::app_url('/planes/' . $arr[0] . '/asignaturas/' . $arr[1]));
        }

        return new RedirectResponse(Env::app_url('/'));
    }

    private static function __invalidBody(): Response
    {
        return ErrorHandler::show(400, Messages::INVALID_REQUEST, Messages::MUST_SEND_PARAMS);
    }
}

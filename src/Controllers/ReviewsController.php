<?php
namespace App\Controllers;

use AltchaOrg\Altcha\Altcha;
use App\Constants\Messages;
use App\Enums\ReviewTypesEnum;
use App\Models\Report;
use App\Models\Review;
use App\Wrappers\Env;
use App\Wrappers\ErrorHandler;
use App\Wrappers\Misc;
use App\Wrappers\Plates;
use App\Wrappers\Profanity;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use League\CommonMark\CommonMarkConverter;
use Psr\Http\Message\ServerRequestInterface;

class ReviewsController
{
    public static function create(ServerRequestInterface $request): RedirectResponse|Response
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
        $converter = new CommonMarkConverter([
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 15,
            'max_delimiters_per_line' => 200,
        ]);

        $target = $body['target'];
        $msg = Profanity::filter($converter->convert(trim($body['message'])));
        $note = intval($body['note']);
        // Optional
        $username = '';
        if (isset($body['username']) && !empty($body['username'])) {
            $username = Profanity::filter(trim($body['username']));
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

    /**
     * Report form.
     *
     * Path: `/reviews/{review_id}/report`.
     *
     * @param array{"review_id": int} $args
     */
    public static function reportIndex(ServerRequestInterface $request, array $args): Response
    {
        $review_id = $args['review_id'];
        $review = Review::find($review_id);

        if ($review === null) {
            // TODO: to Messages::class
            return ErrorHandler::show(404, 'Not found', 'Report not found');
        }

        return new HtmlResponse(Plates::render('views/report', [
            'review' => $review,
        ]));
    }

    /**
     * Create new report.
     *
     * Path: `/reviews/{review_id}/report`.
     *
     * @param array{"review_id": int} $args
     */
    public static function reportCreate(ServerRequestInterface $request, array $args): Response
    {
        $review_id = $args['review_id'];
        $review = Review::find($review_id);

        if ($review === null) {
            // TODO: to Messages::class
            return ErrorHandler::show(404, 'Not found', 'Report not found');
        }

        $body = $request->getParsedBody();
        if (!($body !== null && isset($body['message'], $body['altcha']))) {
            return self::__invalidBody();
        }

        // Check captcha first
        $altcha = new Altcha(Env::app_key());
        if (!$altcha->verifySolution($body['altcha'], true)) {
            return self::__invalidBody();
        }

        $converter = new CommonMarkConverter([
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 15,
            'max_delimiters_per_line' => 200,
        ]);

        $email = isset($body['email']) &&
            !empty($body['email']) &&
            filter_var($body['email'], FILTER_VALIDATE_EMAIL)
            ? trim($body['email']) : null;

        $msg = $converter->convert(trim($body['message']));

        $report = new Report([
            'review_id' => $review->id,
            'message' => $msg,
            'email' => $email,
        ]);

        $report->save();

        return new RedirectResponse(Env::app_url('/'));
    }

    private static function __invalidBody(): Response
    {
        return ErrorHandler::show(400, Messages::INVALID_REQUEST, Messages::MUST_SEND_PARAMS);
    }
}

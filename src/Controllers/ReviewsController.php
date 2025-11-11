<?php

namespace App\Controllers;

use App\Constants\Extras;
use App\Constants\Messages;
use App\Enums\ReviewTypesEnum;
use App\Models\Report;
use App\Models\Review;
use App\Wrappers\Env;
use App\Wrappers\Render;
use App\Wrappers\Session;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use League\Route\Http\Exception\ForbiddenException;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Http\Exception\UnauthorizedException;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class ReviewsController extends Controller
{
    /**
     * Get specific review.
     *
     * Path: `/reviews/{review_id}`.
     *
     * @param array{"review_id": int} $args
     */
    public static function index(ServerRequestInterface $request, array $args): Response
    {
        $review_id = $args['review_id'];
        /** @var ?Review */
        $review = Review::find($review_id);
        if ($review === null) {
            throw new NotFoundException();
        }

        return self::__render('views/review', $request, [
            'review' => $review,
        ]);
    }

    public static function create(ServerRequestInterface $request): Response
    {
        $body = $request->getParsedBody();
        if (!($body !== null && isset($body['target'], $body['type'], $body['message'], $body['note'], $body['h-captcha-response']) && is_numeric($body['note']))) {
            throw self::__invalidBody();
        }

        $type = ReviewTypesEnum::tryFrom($body['type']);
        if ($type === null) {
            throw self::__invalidBody();
        }

        if (mb_strlen($body['message'], 'UTF-8') > Review::MESSAGE_MAX_LENGTH) {
            throw self::__tooManyChars();
        }

        if (isset($body['username']) && mb_strlen($body['username'], 'UTF-8') > Review::USERNAME_MAX_LENGTH) {
            throw self::__tooManyChars();
        }

        $note = intval($body['note']);
        if ($note < 0 || $note > 10) {
            throw self::__invalidBody();
        }

        // Check captcha
        self::__runCaptcha($body['h-captcha-response'], $request->getServerParams());

        $target = $body['target'];
        $rawMsg = trim($body['message']);
        // Check if user is trying to be funny
        $url = Extras::review($rawMsg);
        if ($url !== null) {
            return new RedirectResponse($url);
        }

        $msg = Render::markdown(trim($body['message']));

        // Optional
        $username = null;
        if (isset($body['username']) && !empty($body['username'])) {
            $username = trim($body['username']);
        }


        $review = new Review([
            'type' => $type,
            'target' => $target,
            'message' => $msg,
            'note' => $note,
            'username' => $username,
        ]);
        $review->save();

        return new RedirectResponse(Env::app_url('/redirect', [
            'target' => $target,
            'type' => $type,
        ]));
    }

    public static function like(ServerRequestInterface $request, array $args): Response
    {
        return self::__vote($args['review_id'], true, $request->getQueryParams());
    }

    public static function dislike(ServerRequestInterface $request, array $args): Response
    {
        return self::__vote($args['review_id'], false, $request->getQueryParams());
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

        /** @var ?Review */
        $review = Review::find($review_id);

        if ($review === null) {
            throw new NotFoundException('Valoración no encontrada');
        }

        if ($review->accepted_report !== null) {
            throw new ForbiddenException('Esta valoración ya ha sido eliminada');
        }

        return self::__render('views/reports/new', $request, [
            'review' => $review,
        ]);
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
            throw new NotFoundException('Valoración no encontrada');
        }

        $body = $request->getParsedBody();
        if (!($body !== null && isset($body['message'], $body['h-captcha-response']))) {
            throw self::__invalidBody();
        }

        if (mb_strlen($body['message'], 'UTF-8') > Report::MESSAGE_MAX_LENGTH) {
            throw self::__tooManyChars();
        }

        if (isset($body['email']) && mb_strlen($body['email'], 'UTF-8') > Report::EMAIL_MAX_LENGTH) {
            throw self::__tooManyChars();
        }

        // Check captcha first
        self::__runCaptcha($body['h-captcha-response'], $request->getServerParams());

        $email = null;
        if (isset($body['email']) && !empty($body['email']) && filter_var($body['email'], FILTER_VALIDATE_EMAIL)) {
            $email = trim($body['email']);
        }

        $msg = Render::markdown(trim($body['message']));
        $uuid = Uuid::uuid4()->toString();

        $report = new Report([
            'uuid' => $uuid,
            'review_id' => $review->id,
            'message' => $msg,
            'email' => $email,
        ]);

        $report->save();

        return self::__render('views/reports/created', $request, [
            'report' => $report,
            'back' => $review->type->url($review->target),
        ]);
    }

    private static function __vote(int $id, bool $up, array $query): Response
    {
        if (Session::hasVoted($id)) {
            throw new UnauthorizedException(Messages::ALREADY_VOTED);
        }

        if (!isset($query['back'])) {
            throw self::__invalidParams();
        }

        $review = Review::find($id);

        if ($review === null) {
            throw new NotFoundException();
        }

        Session::vote($id);
        $delta = $up ? $review->votes + 1 : $review->votes - 1;
        $review->votes = $delta;
        $review->save();

        return new RedirectResponse(Env::app_url(htmlspecialchars_decode($query['back'])));
    }
}

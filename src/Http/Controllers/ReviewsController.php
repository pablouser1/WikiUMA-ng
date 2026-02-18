<?php

namespace App\Http\Controllers;

use App\Constants\Extras;
use App\Constants\Messages;
use App\Enums\ReviewTypesEnum;
use App\Models\Review;
use App\Wrappers\Env;
use App\Wrappers\Render;
use App\Wrappers\Session;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Http\Exception\UnauthorizedException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Reviews Controller.
 */
class ReviewsController extends Controller
{
    /**
     * Show review form.
     *
     * - Route: `/reviews`
     * - Method: `GET`
     */
    public static function index(ServerRequestInterface $request): Response
    {
        $query = $request->getQueryParams();

        if (!isset($query['target'], $query['type'])) {
            throw self::__invalidParams();
        }

        $type = ReviewTypesEnum::tryFrom($query['type']);
        if ($type === null) {
            throw self::__invalidParams();
        }

        if ($type->isReadOnly()) {
            throw self::__inconsistentData();
        }

        $target = $query['target'];

        if (!$type->isValidTarget($target)) {
            throw self::__inconsistentData();
        }

        return self::__render('views/reviews/new', $request, [
            'type' => $type,
            'target' => $target,
        ]);
    }

    /**
     * Get specific review.
     *
     * Path: `/reviews/{review_id}`.
     *
     * @param array{"review_id": int} $args
     */
    public static function show(ServerRequestInterface $request, array $args): Response
    {
        $review_id = $args['review_id'];
        /** @var ?Review */
        $review = Review::find($review_id);
        if ($review === null) {
            throw new NotFoundException();
        }

        return self::__render('views/reviews/single', $request, [
            'review' => $review,
        ]);
    }

    /**
     * Create review.
     *
     * - Route: `/reviews`
     * - Method: `POST`
     */
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

        if ($type->isReadOnly()) {
            throw self::__inconsistentData();
        }

        $target = $body['target'];

        if (!$type->isValidTarget($target)) {
            throw self::__inconsistentData();
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

        // Create review
        $review = new Review([
            'type' => $type,
            'target' => $target,
            'message' => $msg,
            'note' => $note,
            'username' => $username,
        ]);
        $review->save();

        $back = Env::app_url('/redirect', [
            'target' => $target,
            'type' => $type,
        ]);

        return self::__render('views/reviews/created', $request, [
            'review' => $review,
            'back' => $back,
        ]);
    }

    public static function like(ServerRequestInterface $request, array $args): Response
    {
        return self::__vote($args['review_id'], true, $request->getQueryParams());
    }

    public static function dislike(ServerRequestInterface $request, array $args): Response
    {
        return self::__vote($args['review_id'], false, $request->getQueryParams());
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

        if ($review->type->isReadOnly()) {
            throw self::__inconsistentData();
        }

        Session::vote($id);
        $delta = $up ? $review->votes + 1 : $review->votes - 1;
        $review->votes = $delta;
        $review->save();

        return new RedirectResponse(Env::app_url(htmlspecialchars_decode($query['back'])));
    }
}

<?php

namespace App\Controllers;

use AltchaOrg\Altcha\Altcha;
use App\Enums\ReviewTypesEnum;
use App\Models\Report;
use App\Models\Review;
use App\Wrappers\CustomCheck;
use App\Wrappers\Env;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use League\CommonMark\CommonMarkConverter;
use League\Route\Http\Exception\ForbiddenException;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class ReviewsController extends Controller
{
    public static function create(ServerRequestInterface $request): Response
    {
        $body = $request->getParsedBody();
        if (!($body !== null && isset($body['target'], $body['type'], $body['message'], $body['note'], $body['altcha']) && is_numeric($body['note']))) {
            throw self::__invalidBody();
        }

        $type = ReviewTypesEnum::tryFrom($body['type']);
        if ($type === null) {
            throw self::__invalidBody();
        }

        // Check captcha first
        $altcha = new Altcha(Env::app_key());
        if (!$altcha->verifySolution($body['altcha'], true)) {
            throw self::__invalidBody();
        }

        // Captcha is OK from now on
        $converter = new CommonMarkConverter([
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 15,
            'max_delimiters_per_line' => 200,
        ]);

        $checker = new CustomCheck();

        $target = $body['target'];
        $msg = $checker->cleanWords($converter->convert(trim($body['message'])));
        $note = intval($body['note']);
        // Optional
        $username = null;
        if (isset($body['username']) && !empty($body['username'])) {
            $username = $checker->cleanWords(trim($body['username']));
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
        };

        return self::__render('views/reports/new', [
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
        if (!($body !== null && isset($body['message'], $body['altcha']))) {
            throw self::__invalidBody();
        }

        // Check captcha first
        $altcha = new Altcha(Env::app_key());
        if (!$altcha->verifySolution($body['altcha'], true)) {
            throw self::__invalidBody();
        }

        $converter = new CommonMarkConverter([
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 15,
            'max_delimiters_per_line' => 200,
        ]);

        $email = null;
        if (isset($body['email']) && !empty($body['email']) && filter_var($body['email'], FILTER_VALIDATE_EMAIL)) {
            $email = trim($body['email']);
        }

        $msg = $converter->convert(trim($body['message']));
        $uuid = Uuid::uuid4()->toString();

        $report = new Report([
            'uuid' => $uuid,
            'review_id' => $review->id,
            'message' => $msg,
            'email' => $email,
        ]);

        $report->save();

        return self::__render('views/reports/created', [
            'report' => $report,
            'back' => $review->type->url($review->target),
        ]);
    }
}

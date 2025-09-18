<?php
namespace App\Controllers;

use AltchaOrg\Altcha\Altcha;
use App\Constants\Messages;
use App\Enums\ReviewTypesEnum;
use App\Models\Report;
use App\Models\Review;
use App\Wrappers\Env;
use App\Wrappers\MsgHandler;
use App\Wrappers\Misc;
use App\Wrappers\Plates;
use App\Wrappers\Profanity;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use League\CommonMark\CommonMarkConverter;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\ForbiddenException;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ServerRequestInterface;

class ReviewsController
{
    public static function create(ServerRequestInterface $request): RedirectResponse
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

        $target = $body['target'];
        $msg = Profanity::filter($converter->convert(trim($body['message'])));
        $note = intval($body['note']);
        // Optional
        $username = null;
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

        return self::__redirect($target, $type);
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

        $report = new Report([
            'review_id' => $review->id,
            'message' => $msg,
            'email' => $email,
        ]);

        $report->save();

        return MsgHandler::show(
            200,
            'Queja creada',
            'Tu queja ha sido creada y está siendo valorada por la administración de WikiUMA.',
            self::__buildRedirectUrl($review->target, $review->type),
        );

    }

    private static function __invalidBody(): BadRequestException
    {
        return new BadRequestException(Messages::MUST_SEND_PARAMS);
    }

    private static function __redirect(string $target, ReviewTypesEnum $type): Response
    {
        return new RedirectResponse(self::__buildRedirectUrl($target, $type));
    }

    private static function __buildRedirectUrl(string $target, ReviewTypesEnum $type): string
    {
        if ($type === ReviewTypesEnum::TEACHER) {
            return Env::app_url('/profesores', ['idnc' => $target]);
        } else if ($type === ReviewTypesEnum::SUBJECT) {
            $arr = Misc::planAsignaturaSplit($target);
            return Env::app_url('/planes/' . $arr[0] . '/asignaturas/' . $arr[1]);
        }

        return Env::app_url('/');
    }
}

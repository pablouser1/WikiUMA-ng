<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Review;
use App\Models\User;
use App\Wrappers\Mail;
use App\Wrappers\Render;
use Laminas\Diactoros\Response;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Http\Exception\UnauthorizedException;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class ReportsController extends Controller
{
    /**
     * Report form.
     *
     * Path: `/reports`.
     */
    public static function index(ServerRequestInterface $request): Response
    {
        $query = $request->getQueryParams();

        $review_id = self::__parseIntFromQuery('review', $query, null);
        if ($review_id === null) {
            throw self::__invalidParams();
        }

        /** @var ?Review */
        $review = Review::find($review_id);
        if ($review === null) {
            throw new NotFoundException('Valoración no encontrada');
        }

        if ($review->type->isReadOnly()) {
            throw self::__inconsistentData();
        }

        if ($review->accepted_report !== null) {
            throw new UnauthorizedException('Esta valoración ya ha sido eliminada');
        }

        return self::__render('views/reports/new', $request, [
            'review' => $review,
        ]);
    }

    /**
     * Create new report.
     *
     * Path: `/reports`.
     */
    public static function create(ServerRequestInterface $request): Response
    {
        $query = $request->getQueryParams();

        $review_id = self::__parseIntFromQuery('review', $query, null);
        if ($review_id === null) {
            throw self::__invalidParams();
        }

        $review = Review::find($review_id);
        if ($review === null) {
            throw new NotFoundException('Valoración no encontrada');
        }

        if ($review->type->isReadOnly()) {
            throw self::__inconsistentData();
        }

        $body = $request->getParsedBody();
        if (!($body !== null && isset($body['message'], $body['h-captcha-response']))) {
            throw self::__invalidBody();
        }

        if (mb_strlen($body['message'], 'UTF-8') > Report::MESSAGE_MAX_LENGTH) {
            throw self::__tooManyChars();
        }

        // Check captcha first
        self::__runCaptcha($body['h-captcha-response'], $request->getServerParams());

        $msg = Render::markdown(trim($body['message']));
        $uuid = Uuid::uuid4()->toString();

        $report = new Report([
            'uuid' => $uuid,
            'review_id' => $review->id,
            'message' => $msg,
        ]);

        $report->save();

        $mail = new Mail();

        // Send report notification to all admins
        User::all()->each(function (User $user) use ($report, $mail) {
            $mail->reportNew($report, $user);
        });

        return self::__render('views/reports/created', $request, [
            'report' => $report,
            'back' => $review->type->url($review->target),
        ]);
    }
}

<?php

namespace App\Controllers;

use App\Enums\ReportStatusEnum;
use App\Models\Report;
use App\Models\Review;
use App\Traits\HasReports;
use App\Traits\HasReviews;
use App\Wrappers\Env;
use App\Wrappers\Mail;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

/**
 * Staff Controller.
 */
class StaffController extends Controller
{
    use HasReviews;
    use HasReports;

    public static function reviewIndex(ServerRequestInterface $request): Response
    {
        $query = $request->getQueryParams();
        $filter = self::__getReviewFilter($query['filter'] ?? null);
        $reviews = self::__getReviews(null, null, $query['page'] ?? 1, $filter);

        return self::__render('views/staff/reviews', $request, [
            'reviews' => $reviews,
            'query' => $query,
        ]);
    }

    /**
     * Update status of review.
     *
     * @var array{"review_id": int, "force": ?string} $args
     */
    public static function reviewDelete(ServerRequestInterface $request, array $args): Response
    {
        $body = $request->getParsedBody();
        $review_id = $args['review_id'];
        $review = Review::find($review_id);

        if ($review === null) {
            throw new NotFoundException();
        }

        if (isset($body['force']) && $body['force'] === 'on') {
            $review->delete();
        } else {
            $reason = isset($body['reason']) && !empty($body['reason']) ? trim($body['reason']) : null;

            $uuid = Uuid::uuid4()->toString();
            $report = new Report([
                'uuid' => $uuid,
                'review_id' => $review->id,
                'status' => ReportStatusEnum::ACCEPTED,
                'message' => '',
                'reason' => $reason,
            ]);

            $report->save();
        }

        return new RedirectResponse(Env::app_url('/staff/reviews'));
    }

    public static function reportIndex(ServerRequestInterface $request): Response
    {
        $query = $request->getQueryParams();
        $filter = self::__getReportFilter($query['filter'] ?? null);
        $reports = self::__getReports($query['page'] ?? 1, $filter);

        return self::__render('views/staff/reports', $request, [
            'reports' => $reports,
            'query' => $query,
        ]);
    }

    /**
     * Update status of report.
     *
     * @var array{"report_id": int} $args
     */
    public static function reportStatus(ServerRequestInterface $request, array $args): RedirectResponse
    {
        $body = $request->getParsedBody();
        if (!isset($body['status'])) {
            throw self::__invalidBody();
        }

        $statusStr = $body['status'];
        $status = ReportStatusEnum::tryFrom($statusStr);
        if ($status === null) {
            throw self::__invalidBody();
        }

        $report_id = $args['report_id'];

        /** @var ?Report */
        $report = Report::find($report_id);

        if ($report === null) {
            throw new NotFoundException('Informe no encontrado');
        }

        $reason = isset($body['reason']) && !empty($body['reason']) ? trim($body['reason']) : null;

        $report->status = $status;
        $report->reason = $reason;
        $report->save();

        // Send email if exists
        if (!empty($report->email)) {
            $mail = new Mail();
            $mail->reportStatus($report);
        }

        return new RedirectResponse(Env::app_url('/staff/reports'));
    }
}

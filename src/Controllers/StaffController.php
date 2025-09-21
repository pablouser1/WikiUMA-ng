<?php

namespace App\Controllers;

use App\Constants\Messages;
use App\Enums\ReportStatusEnum;
use App\Models\Report;
use App\Models\User;
use App\Traits\HasReports;
use App\Wrappers\Env;
use App\Wrappers\Mail;
use App\Wrappers\Plates;
use App\Wrappers\Session;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Staff Controller.
 */
class StaffController
{
    use HasReports;

    /**
     * Login form.
     *
     * Route: `/staff/login`.
     */
    public static function loginGet(): Response
    {
        return new HtmlResponse(Plates::render('views/staff/login'));
    }

    /**
     * Login POST.
     *
     * Route: `/staff/login`.
     */
    public static function loginPost(ServerRequestInterface $request): RedirectResponse
    {
        $body = $request->getParsedBody();

        if (!isset($body['username'], $body['password'])) {
            throw new BadRequestException(Messages::MUST_SEND_BODY);
        }

        $username = trim($body['username']);
        $password = trim($body['password']);

        /** @var User */
        $user = User::where('username', '=', $username)->first();

        if ($user === null) {
            throw new BadRequestException(Messages::LOGIN_FAILED);
        }

        if (!$user->checkPassword($password)) {
            throw new BadRequestException(Messages::LOGIN_FAILED);
        }

        Session::login($user->id);

        return new RedirectResponse(Env::app_url('/staff'));
    }

    public static function dashboard(ServerRequestInterface $request): Response
    {
        $uri = $request->getUri();
        $query = $request->getQueryParams();
        $filter = self::__getFilter($query['filter'] ?? null);
        $reports = self::__getReports($query['page'] ?? 1, $filter);
        return new HtmlResponse(Plates::render('views/staff/dashboard', [
            'reports' => $reports,
            'uri' => $uri,
            'query' => $query,
        ]));
    }

    public static function reportStatus(ServerRequestInterface $request, array $args): RedirectResponse
    {
        $body = $request->getParsedBody();
        if (!isset($body['status'])) {
            throw new BadRequestException(Messages::MUST_SEND_BODY);
        }

        $statusStr = $body['status'];
        $status = ReportStatusEnum::tryFrom($statusStr);
        if ($status === null) {
            throw new BadRequestException(Messages::MUST_SEND_BODY);
        }

        $report_id = $args['report_id'];

        /** @var ?Report */
        $report = Report::find($report_id);

        if ($report === null) {
            throw new NotFoundException();
        }

        $reason = isset($body['reason']) && !empty($body['reason']) ? trim($body['reason']) : null;

        $report->status = $status;
        $report->reason = $reason;
        $report->save();

        // Send email if exists
        if (!empty($report->email)) {
            $mail = new Mail;
            $mail->reportStatus($report);
        }

        return new RedirectResponse(Env::app_url('/staff'));
    }
}

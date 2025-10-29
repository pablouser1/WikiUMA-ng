<?php

namespace App\Controllers;

use App\Models\Report;
use App\Wrappers\Security;
use Laminas\Diactoros\Response;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Reports Controller.
 */
class ReportsController extends Controller
{
    /**
     * Form site.
     *
     * Route: `/reports`.
     */
    public static function index(ServerRequestInterface $request): Response
    {
        return self::__render('views/reports/index', $request);
    }

    /**
     * See report details from UUID.
     *
     * - Route: `/reports`
     * - Method: `POST`
     */
    public static function post(ServerRequestInterface $request): Response
    {
        $body = $request->getParsedBody();

        if (!isset($body['uuid'], $body['h-captcha-response'])) {
            throw self::__invalidBody();
        }

        // Check captcha first
        $captchaOk = Security::captcha($body['h-captcha-response']);
        if (!$captchaOk) {
            throw self::__invalidCaptcha();
        }

        $uuid = trim($body['uuid']);
        $report = Report::where('uuid', '=', $uuid)->first();
        if ($report === null) {
            throw new NotFoundException();
        }

        return self::__render('views/reports/single', $request, [
            'report' => $report,
        ]);
    }
}

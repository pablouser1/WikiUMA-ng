<?php

namespace App\Controllers;

use App\Models\Report;
use Laminas\Diactoros\Response;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Reports Checker Controller.
 */
class ReportsCheckerController extends Controller
{
    /**
     * Form site.
     *
     * Route: `/reports/checker`.
     */
    public static function index(ServerRequestInterface $request): Response
    {
        return self::__render('views/reports/checker/index', $request);
    }

    /**
     * See report details from UUID.
     *
     * - Route: `/reports/checker`
     * - Method: `POST`
     */
    public static function post(ServerRequestInterface $request): Response
    {
        $body = $request->getParsedBody();

        if (!isset($body['uuid'], $body['h-captcha-response'])) {
            throw self::__invalidBody();
        }

        // Check captcha first
        self::__runCaptcha($body['h-captcha-response'], $request->getServerParams());

        $uuid = trim($body['uuid']);
        $report = Report::where('uuid', '=', $uuid)->first();
        if ($report === null) {
            throw new NotFoundException();
        }

        return self::__render('views/reports/checker/single', $request, [
            'report' => $report,
        ]);
    }
}

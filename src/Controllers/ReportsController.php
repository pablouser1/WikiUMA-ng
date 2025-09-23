<?php

namespace App\Controllers;

use AltchaOrg\Altcha\Altcha;
use App\Models\Report;
use App\Wrappers\Env;
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
    public static function index(): Response
    {
        return self::__render('views/reports/index');
    }

    public static function post(ServerRequestInterface $request): Response
    {
        $body = $request->getParsedBody();

        if (!isset($body['uuid'], $body['altcha'])) {
            throw self::__invalidBody();
        }

        // Check captcha first
        $altcha = new Altcha(Env::app_key());
        if (!$altcha->verifySolution($body['altcha'], true)) {
            throw self::__invalidBody();
        }

        $uuid = trim($body['uuid']);
        $report = Report::where('uuid', '=', $uuid)->first();
        if ($report === null) {
            throw new NotFoundException();
        }

        return self::__render('views/reports/single', [
            'report' => $report,
        ]);
    }
}

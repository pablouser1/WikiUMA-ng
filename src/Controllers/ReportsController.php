<?php

namespace App\Controllers;

use AltchaOrg\Altcha\Altcha;
use App\Constants\Messages;
use App\Models\Report;
use App\Wrappers\Env;
use App\Wrappers\Plates;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use League\Route\Http\Exception\BadRequestException;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Reports Controller.
 */
class ReportsController
{
    /**
     * Form site.
     *
     * Route: `/reports`.
     */
    public static function index(): Response
    {
        return new HtmlResponse(Plates::render('views/reports/index'));
    }

    public static function post(ServerRequestInterface $request): Response
    {
        $body = $request->getParsedBody();

        if (!isset($body['uuid'], $body['altcha'])) {
            throw new BadRequestException(Messages::MUST_SEND_BODY);
        }

        // Check captcha first
        $altcha = new Altcha(Env::app_key());
        if (!$altcha->verifySolution($body['altcha'], true)) {
            throw new BadRequestException(Messages::MUST_SEND_BODY);
        }

        $uuid = trim($body['uuid']);
        $report = Report::where('uuid', '=', $uuid)->first();
        if ($report === null) {
            throw new NotFoundException();
        }

        return new HtmlResponse(Plates::render('views/reports/single', [
            'report' => $report
        ]));
    }
}

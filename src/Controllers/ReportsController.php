<?php

namespace App\Controllers;

use App\Wrappers\Plates;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;

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
}

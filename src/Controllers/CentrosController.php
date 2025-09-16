<?php
namespace App\Controllers;

use App\Api;
use App\Wrappers\ErrorHandler;
use App\Wrappers\Plates;
use Laminas\Diactoros\Response\HtmlResponse;

/**
 * Centros controller
 */
class CentrosController
{
    /**
     * Get all faculties.
     *
     * Route: `/centros`.
     */
    public static function index()
    {
        $api = new Api;
        $centros = $api->centros();
        if (!$centros->success) {
            return ErrorHandler::showFromApiRes($centros);
        }

        return new HtmlResponse(Plates::render('views/centros', ['centros' => $centros->data]));
    }
}

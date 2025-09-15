<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap.php';

use App\Constants\Messages;
use App\Controllers\AsignaturasController;
use App\Controllers\CentrosController;
use App\Controllers\HomeController;
use App\Controllers\PlanesController;
use App\Controllers\ProfesoresController;
use App\Controllers\SearchController;
use App\Controllers\TitulacionesController;
use App\Wrappers\Plates;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Http\Exception;

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router = new League\Route\Router;

// -- ROUTES -- //
$router->get('/', [HomeController::class, 'index']);
$router->get('/centros', [CentrosController::class, 'index']);
$router->get('/centros/{centro_id:number}/titulaciones', [TitulacionesController::class, 'index']);
$router->get('/planes/{plan_id:number}', [PlanesController::class, 'index']);
$router->get('/planes/{plan_id:number}/asignaturas/{asignatura_id:number}', [AsignaturasController::class, 'index']);
$router->get('/profesores', [ProfesoresController::class, 'index']);

$router->get('/search', [SearchController::class, 'index']);
// -- END ROUTES -- //

$response = null;

try {
    $response = $router->dispatch($request);
} catch (Exception $e) {
    $response = new HtmlResponse(Plates::renderError("Error {$e->getStatusCode()}", $e->getMessage()), $e->getStatusCode());
} /*catch (\Throwable $e) {
    $response = new HtmlResponse(Plates::renderError(Messages::UNKNOWN_ERROR, $e->getMessage()), 500);
}*/

// send the response to the browser
(new SapiEmitter)->emit($response);

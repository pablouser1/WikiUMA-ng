<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap.php';

use App\Constants\Messages;
use App\Controllers\AsignaturasController;
use App\Controllers\CentrosController;
use App\Controllers\ChallengeController;
use App\Controllers\DevController;
use App\Controllers\HomeController;
use App\Controllers\MiscController;
use App\Controllers\PlanesController;
use App\Controllers\ProfesoresController;
use App\Controllers\ReviewsController;
use App\Controllers\SearchController;
use App\Controllers\TitulacionesController;
use App\Wrappers\Env;
use App\Wrappers\MsgHandler;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Http\Exception;
use League\Route\RouteGroup;

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router = new League\Route\Router;

// -- ROUTES -- //
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [MiscController::class, 'about']);
$router->get('/legal', [MiscController::class, 'legal']);

$router->get('/centros', [CentrosController::class, 'index']);
$router->get('/centros/{centro_id:number}/titulaciones', [TitulacionesController::class, 'index']);
$router->get('/planes/{plan_id:number}', [PlanesController::class, 'index']);
$router->get('/planes/{plan_id:number}/asignaturas/{asignatura_id:number}', [AsignaturasController::class, 'index']);
$router->get('/profesores', [ProfesoresController::class, 'index']);

$router->get('/search', [SearchController::class, 'index']);
$router->get('/challenge', [ChallengeController::class, 'index']);

$router->post('/reviews', [ReviewsController::class, 'create']);
$router->get('/reviews/{review_id:number}/report', [ReviewsController::class, 'reportIndex']);
$router->post('/reviews/{review_id:number}/report', [ReviewsController::class, 'reportCreate']);

if (Env::app_debug()) {
    $router->group('/dev', function (RouteGroup $route) {
        $route->get('/reactions/{code:number}', [DevController::class, 'reactions']);
    });
}
// -- END ROUTES -- //

$response = null;

try {
    $response = $router->dispatch($request);
} catch (Exception $e) {
    $response = MsgHandler::error($e->getStatusCode(), "Error {$e->getStatusCode()}", $e->getMessage());
} catch (\Throwable $e) {
    // Rethrow if debugging
    if (Env::app_debug()) {
        throw $e;
    }

    $response = MsgHandler::error(500, Messages::UNKNOWN_ERROR, $e->getMessage());
}

// send the response to the browser
(new SapiEmitter)->emit($response);

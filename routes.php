<?php

use App\Controllers\AsignaturasController;
use App\Controllers\CentrosController;
use App\Controllers\ChallengeController;
use App\Controllers\DevController;
use App\Controllers\HomeController;
use App\Controllers\MiscController;
use App\Controllers\PlanesController;
use App\Controllers\ProfesoresController;
use App\Controllers\RedirectController;
use App\Controllers\ReportsController;
use App\Controllers\ReviewsController;
use App\Controllers\SearchController;
use App\Controllers\StaffController;
use App\Controllers\TitulacionesController;
use App\Middleware\AuthMiddleware;
use App\Wrappers\Env;
use League\Route\RouteGroup;

/** @var League\Route\Router $router */

$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [MiscController::class, 'about']);
$router->get('/legal', [MiscController::class, 'legal']);
$router->get('/redirect', [RedirectController::class, 'index']);
$router->get('/search', [SearchController::class, 'index']);

$router->group('/reports', function (RouteGroup $route) {
    $route->get('/', [ReportsController::class, 'index']);
    $route->post('/', [ReportsController::class, 'post']);
});

$router->get('/centros', [CentrosController::class, 'index']);
$router->get('/centros/{centro_id:number}/titulaciones', [TitulacionesController::class, 'index']);
$router->group('/planes/{plan_id:number}', function (RouteGroup $route) {
    $route->get('/', [PlanesController::class, 'index']);
    $route->get('/asignaturas/{asignatura_id:number}', [AsignaturasController::class, 'index']);
});

$router->get('/profesores', [ProfesoresController::class, 'index']);
$router->get('/challenge', [ChallengeController::class, 'index']);

$router->post('/reviews', [ReviewsController::class, 'create']);
$router->group('/reviews/{review_id:number}', function (RouteGroup $route) {
    $route->get('/', [ReviewsController::class, 'index']);
    $route->get('/like', [ReviewsController::class, 'like']);
    $route->get('/dislike', [ReviewsController::class, 'dislike']);
    $route->get('/report', [ReviewsController::class, 'reportIndex']);
    $route->post('/report', [ReviewsController::class, 'reportCreate']);
});

$router->group('/staff', function (RouteGroup $route) {
    $route->get('/', [StaffController::class, 'dashboard']);
    $route->get('/login', [StaffController::class, 'loginGet']);
    $route->post('/login', [StaffController::class, 'loginPost']);
    $route->get('/logout', [StaffController::class, 'logout']);
    $route->post('/reports/{report_id:number}/status', [StaffController::class, 'reportStatus']);
})->middleware(new AuthMiddleware());

if (Env::app_debug()) {
    $router->group('/dev', function (RouteGroup $route) {
        $route->get('/reactions/{code:number}', [DevController::class, 'reactions']);
    });
}

<?php

use App\Controllers\AsignaturasController;
use App\Controllers\AuthController;
use App\Controllers\CentrosController;
use App\Controllers\DevController;
use App\Controllers\HallController;
use App\Controllers\HomeController;
use App\Controllers\MiscController;
use App\Controllers\PlanesController;
use App\Controllers\ProfesoresController;
use App\Controllers\RedirectController;
use App\Controllers\ReportsCheckerController;
use App\Controllers\ReportsController;
use App\Controllers\ReviewsController;
use App\Controllers\SearchController;
use App\Controllers\StaffController;
use App\Controllers\TipsController;
use App\Middleware\AuthMiddleware;
use App\Wrappers\Env;
use League\Route\RouteGroup;

/** @var League\Route\Router $router */

$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [MiscController::class, 'about']);
$router->get('/legal', [MiscController::class, 'legal']);
$router->get('/contact', [MiscController::class, 'contact']);
$router->get('/maintenance', [MiscController::class, 'maintenance']);
$router->get('/redirect', [RedirectController::class, 'index']);
$router->get('/search', [SearchController::class, 'index']);
$router->get('/hall', [HallController::class, 'index']);

$router->group('/tips', function (RouteGroup $route) {
    $route->get('/', [TipsController::class, 'index']);
    $route->get('/email', [TipsController::class, 'email']);
});

$router->group('/reports', function (RouteGroup $route) {
    $route->get('/', [ReportsController::class, 'index']);
    $route->post('/', [ReportsController::class, 'create']);
});

$router->group('/reports/checker', function (RouteGroup $route) {
    $route->get('/', [ReportsCheckerController::class, 'index']);
    $route->post('/', [ReportsCheckerController::class, 'post']);
});

$router->get('/centros', [CentrosController::class, 'index']);
$router->get('/centros/{centro_id:number}/titulaciones', [CentrosController::class, 'titulaciones']);
$router->group('/planes/{plan_id:number}', function (RouteGroup $route) {
    $route->get('/', [PlanesController::class, 'index']);
    $route->get('/asignaturas/{asignatura_id:number}', [AsignaturasController::class, 'index']);
});

$router->get('/profesores', [ProfesoresController::class, 'index']);

$router->get('/reviews', [ReviewsController::class, 'index']);
$router->post('/reviews', [ReviewsController::class, 'create']);
$router->group('/reviews/{review_id:number}', function (RouteGroup $route) {
    $route->get('/', [ReviewsController::class, 'show']);
    $route->get('/like', [ReviewsController::class, 'like']);
    $route->get('/dislike', [ReviewsController::class, 'dislike']);
});

$router->group('/staff', function (RouteGroup $route) {
    // -- Auth -- //
    $route->get('/login', [AuthController::class, 'index']);
    $route->post('/login', [AuthController::class, 'post']);
    $route->get('/logout', [AuthController::class, 'logout']);

    // -- Dashboard -- //
    $route->get('/reviews', [StaffController::class, 'reviewIndex']);
    $route->post('/reviews/{review_id:number}/delete', [StaffController::class, 'reviewDelete']);
    $route->get('/reports', [StaffController::class, 'reportIndex']);
    $route->post('/reports/{report_id:number}/status', [StaffController::class, 'reportStatus']);
})->middleware(new AuthMiddleware());

if (Env::app_debug()) {
    $router->group('/dev', function (RouteGroup $route) {
        $route->get('/reactions/{code:number}', [DevController::class, 'reactions']);
    });
}

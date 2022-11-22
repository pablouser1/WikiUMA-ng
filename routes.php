<?php
/** @var \Bramus\Router\Router $router */

use App\Helpers\Wrappers;

$router->set404(function () {
    Wrappers::plates('error', [
        'code' => 404,
        'body' => 'Not found'
    ]);
});

$router->get('/', 'HomeController@get');
$router->get('/about', function () {
    Wrappers::plates('about');
});

$router->get('/centros', 'CentrosController@get');
$router->get('/centros/titulaciones/(\d+)', 'TitulacionesController@get');
$router->get('/plan/(\d+)', 'PlanController@get');
$router->get('/asignaturas/(\d+)/(\d+)', 'AsignaturaController@get');
$router->get('/profesores', 'ProfesorController@get');
$router->get('/captcha', 'CaptchaController@get');

$router->mount('/reviews', function () use ($router) {
    $router->post('/', 'ReviewController@post');
    $router->get('/(\d+)/delete', 'ReviewController@delete');
});

$router->mount('/reports', function () use ($router) {
    $router->get('/new/(\d+)', 'ReporteController@get');
    $router->post('/new/(\d+)', 'ReporteController@post');
    $router->get('/(\d+)/delete', 'ReporteController@delete');
});

$router->mount('/admin', function () use ($router) {
    $router->get('/', 'AdminController@get');
    $router->get('/login', 'AdminController@loginGet');
    $router->post('/login', 'AdminController@loginPost');
    $router->get('/logout', 'AdminController@logout');
});

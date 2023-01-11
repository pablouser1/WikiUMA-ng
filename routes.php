<?php
/** @var \Bramus\Router\Router $router */

use App\Helpers\Wrappers;

$router->set404(function () {
    Wrappers::plates('message', [
        'code' => 404,
        'title' => 'Error'
    ]);
});

$router->get('/', 'HomeController@get');
$router->get('/about', function () {
    Wrappers::plates('about');
});
$router->get('/legal', function () {
    Wrappers::plates('legal');
});

$router->get('/search', 'SearchController@get');
$router->get('/centros', 'CentrosController@get');
$router->get('/centros/titulaciones/(\d+)', 'TitulacionesController@get');
$router->get('/plan/(\d+)', 'PlanController@get');
$router->get('/asignaturas/(\d+)/(\d+)', 'AsignaturaController@get');
$router->get('/profesores', 'ProfesorController@get');

$router->mount('/reviews', function () use ($router) {
    $router->post('/', 'ReviewController@post');
    $router->get('/(\d+)/delete', 'ReviewController@delete');
    $router->get('/(\d+)/like', 'ReviewController@like');
    $router->get('/(\d+)/dislike', 'ReviewController@dislike');
});

$router->mount('/reports', function () use ($router) {
    $router->get('/new/(\d+)', 'ReporteController@get');
    $router->post('/new/(\d+)', 'ReporteController@post');
    $router->get('/(\d+)/delete', 'ReporteController@delete');
});

$router->mount('/login', function () use ($router) {
    $router->get('/', 'AuthController@loginGet');
    $router->post('/', 'AuthController@loginPost');
});

$router->mount('/register', function () use ($router) {
    $router->get('/', 'AuthController@registerGet');
    $router->post('/', 'AuthController@registerPost');
});

$router->mount('/verify', function () use ($router) {
    $router->get('/', 'AuthController@verifyGet');
    $router->post('/', 'AuthController@verifyPost');
});

$router->get('/logout', 'AuthController@logout');

$router->mount('/tags', function () use ($router) {
    $router->post('/new', 'TagController@create');
    $router->post('/(\d+)/edit', 'TagController@edit');
    $router->get('/(\d+)/delete', 'TagController@delete');
});

$router->mount('/admin', function () use ($router) {
    $router->get('/', 'AdminController@dashboard');
    $router->get('/reports', 'AdminController@reports');
    $router->get('/reviews', 'AdminController@reviews');
    $router->get('/tags', 'AdminController@tags');
});

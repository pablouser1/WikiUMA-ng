<?php
/** @var \Bramus\Router\Router $router */

use App\Helpers\Misc;
use App\Helpers\Wrappers;

$router->get('/', function () {
    $latte = Wrappers::latte();
    $latte->render(Misc::getView('home'), ['title' => 'Inicio']);
});
$router->get('/about', function () {
    $latte = Wrappers::latte();
    $latte->render(Misc::getView('about'), ['title' => 'Acerca de']);
});
$router->get('/captcha', 'CaptchaController@get');
$router->get('/centros', 'CentrosController@show');
$router->get('/centros/titulaciones/(\d+)', 'TitulacionesController@show');
$router->get('/plan/(\d+)', 'PlanController@show');
$router->get('/asignaturas/(\d+)/(\d+)', 'AsignaturaController@show');
$router->mount('/profesores', function () use ($router) {
    $router->get('/', 'ProfesorController@get');
    $router->post('/', 'ProfesorController@post');
});

$router->mount('/admin', function () use ($router) {
    $router->get('/', 'AdminController@get');
    $router->get('/login', 'AdminController@loginGet');
    $router->post('/login', 'AdminController@loginPost');
    $router->get('/logout', 'AdminController@logout');
});

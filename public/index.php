<?php
require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/../bootstrap.php";

// ROUTER
$router = new Bramus\Router\Router();
$router->setNamespace('\App\Controllers');

require __DIR__ . '/../routes.php';

session_start();

$router->run();

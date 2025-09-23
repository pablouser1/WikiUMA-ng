<?php

use App\Wrappers\Env;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;

// -- ENV -- //
Env::parse(__DIR__ . '/.env');

// -- DATABASE -- //
$db = Env::db();
$capsule = new Capsule;

$capsule->addConnection(array_merge($db, [
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => ''
]));

$capsule->setEventDispatcher(new Dispatcher());

// Make this Capsule instance available globally via static methods
$capsule->setAsGlobal();

// Boot Eloquent ORM
$capsule->bootEloquent();

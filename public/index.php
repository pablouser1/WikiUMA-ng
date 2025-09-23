<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap.php';

use App\Constants\Messages;
use App\Wrappers\Env;
use App\Wrappers\MsgHandler;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Http\Exception;

require __DIR__ . '/../functions.php';

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router = new League\Route\Router;

require __DIR__ . '/../routes.php';

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

    logger()->error('Unkown error happened', [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
    ]);

    $response = MsgHandler::error(500, Messages::UNKNOWN_ERROR, $e->getMessage());
}

// send the response to the browser
(new SapiEmitter)->emit($response);

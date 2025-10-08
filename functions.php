<?php

use App\Wrappers\Storage;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

if (!function_exists('logger')) {
    /** @var ?Logger */
    $logger = null;
    function logger(): Logger {
        global $logger;
        if ($logger !== null) {
            return $logger;
        }

        $logger = new Logger('wikiuma');
        $logger->pushHandler(new StreamHandler(Storage::path('wikiuma.log')));

        return $logger;
    }
}

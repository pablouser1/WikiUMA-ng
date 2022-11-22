<?php
$dotenv = new josegonzalez\Dotenv\Loader(__DIR__ . '/.env');
$dotenv->raiseExceptions(false);
$result = $dotenv->parse();
if ($result !== false) {
    $dotenv->toEnv();
}

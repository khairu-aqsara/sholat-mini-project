<?php

use Khairu\Sholat\Controllers\HomeController;
use Khairu\Sholat\Exceptions\ExceptionLogger;
use Khairu\Sholat\Routes\Router;

$router = new Router();
$router->get('/', HomeController::class, 'index');

try {
    $router->dispatch();
}catch (Exception $e) {
    $logger = new ExceptionLogger();
    $logger->report(false, $e->getMessage());
}
<?php
session_start();
require_once 'vendor/autoload.php';

require_once __DIR__ . '/app/config/bootstrap.php';


use Core\Router;

$router = new Router;
$router->run();


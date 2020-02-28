<?php
session_start();

include MAIN_DIR . '/libs/autoload.php';
$config = include (MAIN_DIR . '/bootstrap/cfg.php');

$app = new App\Core\CoreInit($config);

$logger = new \Monolog\Logger('Error Logger');
$file_handler = new \Monolog\Handler\StreamHandler(MAIN_DIR. '/logs/error.log.txt', Monolog\Logger::DEBUG);
$logger->pushHandler($file_handler);
$app->add('logger', $logger);

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($config['db'], 'default');
$capsule->setAsGlobal();
$capsule->bootEloquent();

$app->add('db', $capsule);

$app->get('view')->addGlobal('auth', App\Controllers\AuthController::check());

$app->add('HomeController', 	new App\Controllers\HomeController($app->container));
$app->add('AdminController', 	new App\Controllers\AdminController($app->container));
$app->add('PlayerController', 	new App\Controllers\PlayerController($app->container));
$app->add('SkinController', 	new App\Controllers\SkinController($app->container));
$app->add('ClanController', 	new App\Controllers\ClanController($app->container));

$app->middleware->add(new App\Controllers\Middleware\MessageMiddlewareController($app->container));

include MAIN_DIR . '/app/routes.php';


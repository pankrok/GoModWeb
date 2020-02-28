<?php

ini_set('display_errors', 'on');

$protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';

DEFINE('MAIN_DIR', __DIR__);
DEFINE('BASE_URL',  $protocol .$_SERVER['HTTP_HOST']);

include 'bootstrap/app.php';

$app->run(); 
	

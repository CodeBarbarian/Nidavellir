<?php

/**
 * @name: index.php
 * @description: This is the entrypoint of the application.
 *
 */

use App\Application;
use Core\Forge\Routers\Heimdall;
require dirname(__DIR__) . '/vendor/autoload.php';

error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Initialize the application
 */
/*
try {
	Application::init();
} catch (Exception $e) {
	die('Unable to load the application');
}
*/

Heimdall::get('', ['controller' => "Home", 'action' => 'index']);
Heimdall::post('', ['controller' => "Home", 'action' => 'index']);

Heimdall::get('test', function(){
	echo "This works also very well!";
});

//Heimdall::getRoutes();
Heimdall::dispatch($_SERVER['QUERY_STRING']);
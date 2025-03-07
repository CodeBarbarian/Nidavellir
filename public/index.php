<?php

/**
 * @name: index.php
 * @description: This is the entrypoint of the application.
 *
 */

use App\Application;

require dirname(__DIR__) . '/vendor/autoload.php';

error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Run the application
 */
Application::Run();

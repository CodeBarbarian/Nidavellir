<?php

namespace App;

use Core\Forge\Middleware\Loaders\Route;
use Core\Forge\Routers\Heimdall;

class Application {


	/**
	 * This handles the main control flow of the application loading
	 *
	 * @throws \Exception
	 */
	public static function Run(): void {

		// @TODO: Need a bootstrap class or function to set system variables
		date_default_timezone_set("Europe/Oslo");

		// Start the session
		session_start();

		// Load all the routes
		Route::routesLoader('../App/Routes');

		// Dispatch the router using query_string
		Heimdall::dispatch($_SERVER['QUERY_STRING']);
	}
}
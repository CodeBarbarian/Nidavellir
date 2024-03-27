<?php
/**
 * @Name: Application
 * @Version: 1.0
 * @Description: Used as the entrypoint, and bootstrapper for the application.
 *
 * @package: Nidavellir
 */
namespace App;

use Core\Forge\Middleware\Loaders\Route;
use Core\Forge\Routers\Heimdall;

class Application {
	/**
	 * Application Run (Main Method)
     *
	 * @throws \Exception
	 */
	public static function Run(): void {
		// @TODO: Need a bootstrap to set system variables
        require_once 'Bootstrap.php';

		// Start the session
		session_start();

		// Load all the routes
		Route::routesLoader('../App/Routes');

		// Dispatch the router using query_string
		Heimdall::dispatch($_SERVER['QUERY_STRING']);
	}
}
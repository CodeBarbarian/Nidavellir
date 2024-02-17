<?php

namespace App;

use \App\Routes\Routes;

class Application {
	/**
	 * This handles the main control flow of the application loading
	 *
	 * @throws \Exception
	 */
	public static function init(): void {
		// Start the session
		session_start();

		// Invoke the router
		require_once 'Routes/Routes.php';
	}
}
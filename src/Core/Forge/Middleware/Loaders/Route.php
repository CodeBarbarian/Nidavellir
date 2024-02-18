<?php

namespace Core\Forge\Middleware\Loaders;

class Route {
	/**
	 * This function is used when storing routes in the /app/routes folder.
	 * This function simply loads all the files it finds in the /app/routes directory.
	 *
	 * @param $Path
	 * @return void
	 */
	public static function routesLoader($Path) {
		// List all files in the directory
		foreach (scandir($Path) as $File) {
			// If they end with .php, include them
			if (preg_match('/\X+?.php/', $File, $Matches)) {
				require_once($Path.'/'.$File);
			}
		}
	}
}
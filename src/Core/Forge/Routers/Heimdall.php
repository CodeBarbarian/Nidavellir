<?php
/**
 * This routing class is meant to be used when you need to create quick and easy rest replies!
 */

namespace Core\Forge\Routers;

class Heimdall {
	public static $Routes = [];
	public static $Params = [];

	/**
	 * Create a regex out of the Route
	 *
	 * @param $Route
	 * @return string
	 */
	private static function prepareRoute($Route): string {
		// Convert the route to a regular expression: escape forward slashes
		$Route = preg_replace('/\//', '\\/', $Route);

		// Convert variables e.g. {controller}
		$Route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $Route);

		// Convert variables with custom regular expressions e.g. {id:\d+}
		$Route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $Route);

		// Add start and end delimiters, and case-insensitive flag
		$Route = '/^' . $Route . '$/i';

		return $Route;
	}

	/**
	 * Create a $_GET route
	 *
	 * @param string      $Route
	 * @param false|array $Callback
	 * @return void
	 */
	public static function get(string $Route, false|array|object $Callback = []): void {
		$PreparedRoute = static::prepareRoute($Route);

		static::$Routes['get'][$PreparedRoute] = $Callback;
	}

	/**
	 * Create a $_POST route
	 *
	 * @param string             $Route
	 * @param false|array|object $Callback
	 * @return void
	 */
	public static function post(string $Route, false|array|object $Callback = []): void {
		$PreparedRoute = static::prepareRoute($Route);

		static::$Routes['post'][$PreparedRoute] = $Callback;
	}

	/**
	 * Return routes
	 *
	 * @return array
	 */
	public static function getRoutes(): array {
		return static::$Routes;
	}

	/**
	 * Match the route with the given
	 *
	 * @param string $URL
	 * @param string $Method
	 * @return bool
	 */
	public static function match(string $URL, string $Method): bool {
		// Iterate over the route as Route and its params
		foreach (static::$Routes[$Method] as $Route => $Params) {
			// If we have a route for the URL store it in matches
			if (preg_match($Route, $URL, $Matches)) {
				// Get named capture group values
				foreach ($Matches as $Key => $Match) {
					if (is_string($Key)) {
						$Params[$Key] = $Match;
					}
				}

				// Set the params and return true
				static::$Params = $Params;
				return true;
			}
		}
		// Return false if no route is matched
		return false;
	}

	/**
	 * Return all params
	 *
	 * @return array
	 */
	public static function getParams() : array {
		return static::$Params;
	}

	/**
	 * Return current request method
	 *
	 * @return string
	 */
	public static function getRequestMethod(): string {
		return strtolower($_SERVER['REQUEST_METHOD']);
	}

	/**
	 * Routing Handler.
	 *
	 * @TODO: Implement $_POST support
	 *
	 * @param string $URL
	 * @return void
	 * @throws \Exception
	 */
	public static function dispatch(string $URL): void {
		$URL = static::removeQueryStringVariables($URL);
		$Method = static::getRequestMethod();

        /**
         * Allowed methods
         */
		if (static::match($URL, 'get') && $Method === "get") {
            self::extracted();
		} elseif (static::match($URL, 'post') && $Method === "post") {
            self::extracted();
        }
    }
	/**
	 * Convert the string with hyphens to StudlyCaps,
	 * e.g. post-authors => PostAuthors
	 *
	 * @param string $String
	 * @return string
	 */
	protected static function convertToStudlyCaps(string $String): string {
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $String)));
	}

	/**
	 * Convert the string with hyphens to camelCase,
	 * e.g. add-new => addNew
	 *
	 * @param string $String
	 * @return string
	 */
	protected static function convertToCamelCase(string $String): string {
		return lcfirst(static::convertToStudlyCaps($String));
	}

	/**
	 * Remove the query string variables from the URL (if any). As the full
	 * query string is used for the route, any variables at the end will need
	 * to be removed before the route is matched to the routing table. For
	 * example:
	 *
	 *   URL                           $_SERVER['QUERY_STRING']  Route
	 *   -------------------------------------------------------------------
	 *   localhost                     ''                        ''
	 *   localhost/?                   ''                        ''
	 *   localhost/?page=1             page=1                    ''
	 *   localhost/posts?page=1        posts&page=1              posts
	 *   localhost/posts/index         posts/index               posts/index
	 *   localhost/posts/index?page=1  posts/index&page=1        posts/index
	 *
	 * A URL of the format localhost/?page (one variable name, no value) won't
	 * work however. (NB. The .htaccess file converts the first ? to a & when
	 * it's passed through to the $_SERVER variable).
	 *
	 * @param $URL
	 * @return string The URL with the query string variables removed
	 */
	protected static function removeQueryStringVariables($URL): string {
		if ($URL != '') {
			$parts = explode('&', $URL, 2);

			if (!str_contains($parts[0], '=')) {
				$URL = $parts[0];
			} else {
				$URL = '';
			}
		}

		return $URL;
	}

	/**
	 * Get the namespace for the controller class.
	 * route parameters is added if present.
	 *
	 * @return string The request URL
	 */
	protected static function getNamespace(): string {
		$Namespace = 'App\Controllers\\';

		if (array_key_exists('namespace', static::$Params)) {
			$Namespace .= static::$Params['namespace'] . '\\';
		}

		return $Namespace;
	}

    /**
     * @return void
     * @throws \Exception
     */
    public static function extracted(): void
    {
        if (is_object(static::$Params)) {
            if (is_callable(static::$Params)) {
                call_user_func(static::$Params);
            }
        } else {
            $Controller = static::$Params['controller'];
            $Controller = static::convertToStudlyCaps($Controller);
            $Controller = static::getNamespace() . $Controller;

            if (class_exists($Controller)) {
                $Controller_Object = new $Controller(static::$Params);

                $Action = static::$Params['action'];
                $Action = static::convertToCamelCase($Action);

                if (is_callable([$Controller_Object, $Action])) {
                    $Controller_Object->$Action();
                } else {
                    throw new \Exception("Method $Action (in controller $Controller) not found");
                }
            } else {
                throw new \Exception("Controller class $Controller not found");
            }
        }
    }
}
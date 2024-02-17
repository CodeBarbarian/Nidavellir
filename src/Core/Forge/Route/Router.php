<?php

namespace Core\Forge\Route;

class Router {
	/**
	 * Associative array of routes (the routing table)
	 *
	 * @var array
	 */
	protected array $Routes = [];

	/**
	 * Parameters from the matched route
	 *
	 * @var array
	 */
	protected array $Params = [];

	/**
	 * Add a route to the routing table
	 *
	 * @param string $Route
	 * @param array  $Params
	 * @return void
	 */
	public function add(string $Route, array $Params = []): void {
		// Convert the route to a regular expression: escape forward slashes
		$Route = preg_replace('/\//', '\\/', $Route);

		// Convert variables e.g. {controller}
		$Route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $Route);

		// Convert variables with custom regular expressions e.g. {id:\d+}
		$Route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $Route);

		// Add start and end delimiters, and case-insensitive flag
		$Route = '/^' . $Route . '$/i';

		$this->Routes[$Route] = $Params;
	}

	/**
	 * Get all the routes from the routing table
	 *
	 * @return array
	 */
	public function getRoutes(): array {
		return $this->Routes;
	}

	/**
	 * Match the route to the routes in the routing table, setting the $params
	 * property if a route is found.
	 *
	 * @param string $URL The route URL
	 *
	 * @return boolean  true if a match found, false otherwise
	 */
	public function match(string $URL): bool {
		// Iterate over the route as Route and its params
		foreach ($this->Routes as $Route => $Params) {
			// If we have a route for the URL store it in matches
			if (preg_match($Route, $URL, $Matches)) {
				// Get named capture group values
				foreach ($Matches as $Key => $Match) {
					if (is_string($Key)) {
						$Params[$Key] = $Match;
					}
				}

				// Set the params and return true
				$this->Params = $Params;
				return true;
			}
		}
		// Return false if no route is matched
		return false;
	}

	/**
	 * Get the currently matched parameters
	 *
	 * @return array
	 */
	public function getParams(): array {
		return $this->Params;
	}

	/**
	 * Dispatch the route, creating the controller object and running the
	 * action method
	 *
	 * @param string $URL The route URL
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function dispatch(string $URL): void {
		$URL = $this->removeQueryStringVariables($URL);

		if ($this->match($URL)) {
			$Controller = $this->Params['controller'];
			$Controller = $this->convertToStudlyCaps($Controller);
			$Controller = $this->getNamespace() . $Controller;

			if (class_exists($Controller)) {
				$Controller_Object = new $Controller($this->Params);

				$Action = $this->Params['action'];
				$Action = $this->convertToCamelCase($Action);

				if (is_callable([$Controller_Object, $Action])) {
					$Controller_Object->$Action();

				} else {
					throw new \Exception("Method $Action (in controller $Controller) not found");
				}
			} else {
				throw new \Exception("Controller class $Controller not found");
			}
		} else {
			throw new \Exception('No route matched.', 404);
		}
	}

	/**
	 * Convert the string with hyphens to StudlyCaps,
	 * e.g. post-authors => PostAuthors
	 *
	 * @param string $String
	 * @return string
	 */
	protected function convertToStudlyCaps(string $String): string {
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $String)));
	}

	/**
	 * Convert the string with hyphens to camelCase,
	 * e.g. add-new => addNew
	 *
	 * @param string $String
	 * @return string
	 */
	protected function convertToCamelCase(string $String): string {
		return lcfirst($this->convertToStudlyCaps($String));
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
	protected function removeQueryStringVariables($URL): string {
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
	 * Get the namespace for the controller class. The namespace defined in the
	 * route parameters is added if present.
	 *
	 * @return string The request URL
	 */
	protected function getNamespace(): string {
		$Namespace = 'App\Controllers\\';

		if (array_key_exists('namespace', $this->Params)) {
			$Namespace .= $this->Params['namespace'] . '\\';
		}

		return $Namespace;
	}
}
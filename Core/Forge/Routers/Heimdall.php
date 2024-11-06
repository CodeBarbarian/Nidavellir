<?php
/**
 * This routing class is meant to be used when you need to create quick and easy REST replies!
 */

namespace Core\Forge\Routers;

class Heimdall {
    public static $Routes = [];
    public static $Params = [];

    /**
     * Prepare a regex out of the Route.
     *
     * @param string $Route
     * @return string
     */
    private static function prepareRoute(string $Route): string {
        // Convert the route to a regular expression: escape forward slashes
        $Route = preg_replace('/\//', '\\/', $Route);

        // Convert variables e.g. {controller}
        $Route = preg_replace('/\{([a-zA-Z]+)\}/', '(?P<\1>[a-zA-Z-]+)', $Route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $Route = preg_replace('/\{([a-zA-Z]+):([^\}]+)\}/', '(?P<\1>\2)', $Route);

        // Add start and end delimiters, and case-insensitive flag
        $Route = '/^' . $Route . '$/i';

        return $Route;
    }

    /**
     * Add a route for a specified HTTP method.
     *
     * @param string $method
     * @param string $route
     * @param callable|array|object $callback
     * @return void
     */
    public static function addRoute(string $method, string $route, $callback): void {
        $preparedRoute = static::prepareRoute($route);
        static::$Routes[strtolower($method)][$preparedRoute] = $callback;
    }

    /**
     * Create routes for standard HTTP methods.
     */
    public static function get(string $route, $callback = []) { static::addRoute('get', $route, $callback); }
    public static function post(string $route, $callback = []) { static::addRoute('post', $route, $callback); }
    public static function put(string $route, $callback = []) { static::addRoute('put', $route, $callback); }
    public static function delete(string $route, $callback = []) { static::addRoute('delete', $route, $callback); }
    public static function patch(string $route, $callback = []) { static::addRoute('patch', $route, $callback); }
    public static function options(string $route, $callback = []) { static::addRoute('options', $route, $callback); }
    public static function head(string $route, $callback = []) { static::addRoute('head', $route, $callback); }

    /**
     * Return all routes.
     *
     * @return array
     */
    public static function getRoutes(): array {
        return static::$Routes;
    }

    /**
     * Match the route with the given URL and method.
     *
     * @param string $url
     * @param string $method
     * @return bool
     */
    public static function match(string $url, string $method): bool {
        foreach (static::$Routes[$method] as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                static::$Params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Return all params from the matched route.
     *
     * @return array
     */
    public static function getParams(): array {
        return static::$Params;
    }

    /**
     * Get the current request method.
     *
     * @return string
     */
    public static function getRequestMethod(): string {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Dispatch the route based on URL and HTTP method.
     *
     * @param string $url
     * @return void
     * @throws \Exception
     */
    public static function dispatch(string $url): void {
        $url = static::removeQueryStringVariables($url);
        $method = static::getRequestMethod();

        if (static::match($url, $method)) {
            static::invokeCallback();
        } else {
            throw new \Exception("No route matched for URL '$url' and method '$method'");
        }
    }

    /**
     * Invoke the callback for the matched route.
     *
     * @return void
     * @throws \Exception
     */
    protected static function invokeCallback(): void {
        if (is_object(static::$Params)) {
            if (is_callable(static::$Params)) {
                call_user_func(static::$Params);
            }
        } else {
            $controller = static::convertToStudlyCaps(static::$Params['controller']);
            $controller = static::getNamespace() . $controller;

            if (class_exists($controller)) {
                $controllerObject = new $controller(static::$Params);

                $action = static::convertToCamelCase(static::$Params['action']);

                if (is_callable([$controllerObject, $action])) {
                    $controllerObject->$action();
                } else {
                    throw new \Exception("Method $action (in controller $controller) not found");
                }
            } else {
                throw new \Exception("Controller class $controller not found");
            }
        }
    }

    /**
     * Convert a hyphenated string to StudlyCaps.
     *
     * @param string $string
     * @return string
     */
    protected static function convertToStudlyCaps(string $string): string {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert a hyphenated string to camelCase.
     *
     * @param string $string
     * @return string
     */
    protected static function convertToCamelCase(string $string): string {
        return lcfirst(static::convertToStudlyCaps($string));
    }

    /**
     * Remove query string variables from the URL.
     *
     * @param string $url
     * @return string
     */
    protected static function removeQueryStringVariables(string $url): string {
        if ($url != '') {
            $parts = explode('&', $url, 2);
            if (!str_contains($parts[0], '=')) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }

    /**
     * Get the namespace for the controller class.
     *
     * @return string
     */
    protected static function getNamespace(): string {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', static::$Params)) {
            $namespace .= static::$Params['namespace'] . '\\';
        }

        return $namespace;
    }
}

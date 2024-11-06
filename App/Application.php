<?php

/**
 * @Name: Application
 * @Version: 1.1
 * @Description: Entry point and bootstrapper for the Nidavellir application.
 *
 * @package: Nidavellir
 */

namespace App;

use Core\Forge\Middleware\Loaders\Route;
use Core\Forge\Routers\Heimdall;

class Application {

    /**
     * Main entry point to run the application.
     *
     * @return void
     */
    public static function run(): void {
        try {
            self::bootstrap();
            self::initializeSession();
            self::loadRoutes();
            self::dispatchRouter();
        } catch (\Exception $e) {
            // Handle exceptions using a custom error handler or log
            self::handleException($e);
        }
    }

    /**
     * Bootstrap application settings (timezone, environment, etc.).
     *
     * @return void
     */
    private static function bootstrap(): void {
        // Load bootstrap configurations
        require_once 'Bootstrap.php';

        // Set system variables
        date_default_timezone_set("Europe/Oslo");
        // Other configuration-related bootstrapping can go here
    }

    /**
     * Initialize the session for the application.
     *
     * @return void
     */
    private static function initializeSession(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * Load all routes from the routes directory.
     *
     * @return void
     * @throws \Exception if route loading fails
     */
    private static function loadRoutes(): void {
        $routePath = dirname(__DIR__) . '/App/Routes';
        Route::routesLoader($routePath);
    }

    /**
     * Dispatch the router to handle the request based on the query string.
     *
     * @return void
     */
    private static function dispatchRouter(): void {
        // Dispatch the router with the query string
        Heimdall::dispatch($_SERVER['QUERY_STRING']);
    }

    /**
     * Handle uncaught exceptions in a centralized way.
     *
     * @param \Exception $e
     * @return void
     */
    private static function handleException(\Exception $e): void {
        // Log or display the error using a custom error handler
        error_log($e->getMessage());
        // Optionally, display a generic error message to the user
        echo "An error occurred. Please try again later.";
        // Implement additional error handling as needed
    }
}

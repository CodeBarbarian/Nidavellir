<?php

namespace Core\Forge\Middleware\Loaders;

class Route {
    /**
     * Loads all PHP route files from the specified directory.
     *
     * @param string $path Directory path containing route files.
     * @return void
     * @throws \Exception if the directory does not exist or is not readable.
     */
    public static function routesLoader(string $path): void {
        // Verify the path is a valid, readable directory
        if (!is_dir($path) || !is_readable($path)) {
            throw new \Exception("Directory '$path' does not exist or is not readable.");
        }

        // List all files in the directory
        foreach (scandir($path) as $file) {
            $filePath = $path . '/' . $file;

            // Include only PHP files
            if (is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
                require_once $filePath;
            }
        }
    }
}

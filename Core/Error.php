<?php

namespace Core;

use App\Config\Paths;
use ErrorException;
/**
 * Error and exception handler
 * @version: PHP: 8.1
 *
 * @Error
 */
class Error {
	/**
	 * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
	 *
	 * @param $Level
	 * @param $Message
	 * @param $File
	 * @param $Line
	 *
	 * @return void
	 * @throws ErrorException
	 */
	public static function errorHandler($Level, $Message, $File, $Line): void {
		if (error_reporting() !== 0) {  // to keep the @ operator working
			throw new ErrorException($Message, 0, $Level, $File, $Line);
		}
	}

    /**
     * Exception handler.
     *
     * @param $Exception
     *
     * @return void
     * @throws \Exception
     */
	public static function exceptionHandler($Exception): void {
		// Code is 404 (not found) or 500 (general error)
		$Code = $Exception->getCode();

		if ($Code != 404) {
			$Code = 500;
		}

		// Send the response Code
		http_response_code($Code);

		if (\App\Config\Error::SHOW_ERRORS) {
			echo "<h1>Fatal error</h1>";
			echo "<p>Uncaught exception: '" . get_class($Exception) . "'</p>";
			echo "<p>Message: '" . $Exception->getMessage() . "'</p>";
			echo "<p>Stack trace:<pre>" . $Exception->getTraceAsString() . "</pre></p>";
			echo "<p>Thrown in '" . $Exception->getFile() . "' on line " . $Exception->getLine() . "</p>";
		} else {
			$log = dirname(__DIR__) . '/'.Paths::SYSTEM_LOGS.'/' . date('Y-m-d') . '_php.txt';
			ini_set('error_log', $log);

			$Message = "Uncaught exception: '" . get_class($Exception) . "'";
			$Message .= " with message '" . $Exception->getMessage() . "'";
			$Message .= "\nStack trace: " . $Exception->getTraceAsString();
			$Message .= "\nThrown in '" . $Exception->getFile() . "' on line " . $Exception->getLine();

			error_log($Message);

			View::getTemplate($Code . '.html');
		}
	}
}

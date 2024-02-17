<?php
/**
 * This routing class is meant to be used when you need to create quick and easy rest replies!
 */

namespace Core\Forge\Route;

class Heimdall {
	public static $Routes = [];
	public static $Params = [];

	public static function get(string $Route, $Callback = false) {
		static::$Routes['get'][$Route] = $Callback;
	}

	public static function post(string $Route, $Callback = false) {
		static::$Routes['post'][$Route] = $Callback;
	}

	public static function getRoutes() {
		return static::$Routes;
	}
}


/**
 *
 * This router should combine the default router with my old one.
 */


/**
 * Created by PhpStorm.
 * User: Morten Haugstad <morten.haugstad@gmail.com>
 * Date: 08.05.2021
 * Time: 16:57
 */

namespace application\libraries;

class Router {
	public $Routes = [];
	public $Params = [];

	private $Request;

	public function __construct() {
		$this->Request = new Request();
	}

	public function Get(string $Route, $Callback) {
		$this->Routes['get'][$Route] = $Callback;
	}

	public function Post(string $Route, $Callback = false) {
		$this->Routes['post'][$Route] = $Callback;
	}

	public function getRoutes() {
		return $this->Routes;
	}

	public function checkRoute() {
		$URL = $this->Request->splitURL();

		echo $URL['Controller'];
	}

	/**
	 * @throws \Exception
	 */
	public function Dispatch() {
		$Method = $this->Request->getMethod();
		$URL = $this->Request->getURL();

		/**
		 * Maybe we should do a $this->RouteCheck to see if there is something else, than just the route in the
		 * routing table.
		 *
		 * so for instance if we do $Route->Get('{controller}/{action}')
		 *
		 *
		 * */
		$Callback = $this->Routes[$Method][$URL] ?? false;


		if (!$Callback) {
			// Should display an exception here
			throw new \Exception("No callback found $Callback");
		}

		/**
		 * Render the view using the callback
		 * */
		if (is_string($Callback)) {
			echo "Callback is string";
		}

		/**
		 * Build the controller and the action
		 * */
		if (is_array($Callback)) {
			echo "Callback is array";
		}

		if (is_callable($Callback)) {
			call_user_func($Callback);
		}


	}
}


/**
 * Created by PhpStorm.
 * User: Morten Haugstad <morten.haugstad@gmail.com>
 * Date: 08.05.2021
 * Time: 17:06
 */

namespace application\libraries;


class Request {
	public $URL_Controller = null;
	public $URL_Action = null;
	public $URL_Param1 = null;
	public $URL_Param2 = null;
	public $URL_Param3 = null;

	public function getMethod(): string {
		return strtolower($_SERVER['REQUEST_METHOD']);
	}

	public function getURL() {
		return $_SERVER['REQUEST_URI'];
	}

	public function splitURL(): array {
		$URL = $this->getURL();
		$URL = rtrim($URL, '/');
		$URL = filter_var($URL, FILTER_SANITIZE_URL);
		$URL = explode('/', $URL);

		array_shift($URL);

		$State = array(
			"Controller" => ($URL[0] ?? null),
			"Action" => ($URL[1] ?? null),
			"Param1" => ($URL[2] ?? null),
			"Param2" => ($URL[3] ?? null),
			"Param3" => ($URL[4] ?? null)
		);

		if ($State['Controller'])

			return $State;
	}
}
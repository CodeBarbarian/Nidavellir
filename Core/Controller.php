<?php

namespace Core;

use App\Config\Site;


/**
 * Base controller
 * @version: PHP: 8.1
 *
 * @Controller
 */
abstract class Controller {
	/**
	 * Parameters from the matched route
	 *
	 * @var array
	 */
	protected array $route_params = [];

	/**
	 * Class constructor
	 *
	 * @param array $Route_Params Parameters from the route
	 *
	 * @return void
	 */
	public function __construct(array $Route_Params) {
		$this->route_params = $Route_Params;
	}

	/**
	 * Magic method called when a non-existent or inaccessible method is
	 * called on an object of this class. Used to execute before and after
	 * filter methods on action methods. Action methods need to be named
	 * with an "Action" suffix, e.g. indexAction, showAction etc.
	 *
	 * @param string $Name
	 * @param array  $Args
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function __call(string $Name, array $Args) {
		$Method = $Name . 'Action';

		if (method_exists($this, $Method)) {
			/**
			 * This is where the old firewall engine was enforced
			 */

			if ($this->before() !== false) {
				call_user_func_array([$this, $Method], $Args);
				$this->after();
			}
		} else {
			throw new \Exception("Method $Method not found in controller " . get_class($this));
		}
	}

	/**
	 * Before filter - called before an action method.
	 *
	 * @return void
	 */
	protected function before(): void {

	}

	/**
	 * After filter - called after an action method.
	 *
	 * @return void
	 */
	protected function after(): void {

	}

	/**
	 * Redirect to a different page
	 *
	 * @param string $URL The relative URL
	 */
	public function redirect(string $URL): void
	{
		if (Site::SECURE_SERVER_COMMUNICATION) {
			header('Location: https://' . $_SERVER['HTTP_HOST'] . $URL, true, 303);
		} else {
			// Not secure and should never be used, but good for development (in some cases)
			header('Location: http://' . $_SERVER['HTTP_HOST'] . $URL, true, 303);
		}
		exit;
	}
}

<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Forge\Queues\Message;
use Core\Forge\Queues\Queue;

class Production extends Controller {

	/**
	 * Route handler for /company/overview
	 *
	 * @return void
	 */
	public function fabricationAction() : void {
		View::renderTemplate("Production/fabrication.html");
	}

	/**
	 * Route handler for /company/employees
	 *
	 * @return void
	 */
	public function chemistryAction() : void {
		View::renderTemplate("Production/chemistry.html");
	}
}
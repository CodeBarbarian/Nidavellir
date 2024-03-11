<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Forge\Queues\Message;
use Core\Forge\Queues\Queue;

class Services extends Controller {

	/**
	 * Route handler for /company/overview
	 *
	 * @return void
	 */
	public function repairstationAction() : void {
		View::renderTemplate("Services/repairstation.html");
	}

	public function marketAction() : void {
		View::renderTemplate("Services/market.html");
	}
}
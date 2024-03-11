<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Forge\Queues\Message;
use Core\Forge\Queues\Queue;

class Company extends Controller {

	/**
	 * Route handler for /company/overview
	 *
	 * @return void
	 */
	public function overviewAction() : void {
		View::renderTemplate("Company/overview.html");
	}

	/**
	 * Route handler for /company/employees
	 *
	 * @return void
	 */
	public function employeesAction() : void {
		View::renderTemplate("Company/employees.html");
	}

	/**
	 * Route handler for /company/research
	 */
	public function researchAction() : void {
		View::renderTemplate("Company/research.html");
	}

	/**
	 * Route handler for /company/contracts
	 */
	public function contractsAction() : void {
		View::renderTemplate("Company/contracts.html");
	}
}
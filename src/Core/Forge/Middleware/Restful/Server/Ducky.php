<?php

namespace Core\Forge\Middleware\Restful\Server;

class Ducky {
	/**
	 * DUCKY will be our serverside API client. A static based API Service?
	 * 		No database required, only static files?
	 * 	Should support:
	 * 		- JSON
	 * 		- XML
	 * 		- TEXT
	 * 		- HTML
	 * 		- Our own format?
	 *
	 *	Should be built in the following fashion:
	 * 		1. Based on a client id and a client secret
	 * 		2. They can request authorized endpoints
	 * 		3. which are defined in this script
	 *
	 * The funny part here is that we could make sure to only use "Ducky", or use the router we already have
	 * would be more than sufficient to do this.
	 *
	 * So how would the test code look?
	 */

	/**
	 * Defined the routes in Routes! -> API.php
	 */

	/**
	 * Handled in the controller handle, e.g., indexAction
	 */

	/**
	 * Ducky can do the rest!
	 */
}
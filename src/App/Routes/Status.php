<?php
/***************************************************************************************
 * @Name: Status.php
 * @Type: Route
 * @Description: Status API Route. This is one of the many route files.
 * 				 This is used to show that code, and routes can be divided among more
 * 				 files, and if necessary all the routes can also be in one single file.
 * @Version: 1.0
 *
 * @Dependencies: \Core\Forge\Routers\Heimdall
 *
 * @Package: Nidavellir
 ***************************************************************************************/

namespace App\Routes;

use Core\Forge\Routers\Heimdall;

/***************************************************************************************
 * Routing Table - Start
 ***************************************************************************************/

Heimdall::get('status', function(){
	header( 'Content-Type: application/json' );
	http_response_code(200);
	$Response = array("OK");

	echo json_encode($Response);
});

Heimdall::get('time', function() {
	header( 'Content-Type: application/json' );
	http_response_code(200);

	// Start date
	$StartDate = "2024-03-11";

	$Diff = strtotime($StartDate) - strtotime('now');
	$Days = abs(round($Diff / 86400));

	/*
	if ((date('a')) === "pm") {
		$Ticker = "pm";
	} else {
		$Ticker = "am";
	}
	*/

	// Simplify above
	$Ticker = (date("a") === "pm") ? "pm" : "am";

	/**
	 * Build the response
	 */
	$Response = array(
		"meridiem" => $Ticker,
		"server_clock" => (date("h:i:s")),
		"day" => $Days
	);

	echo json_encode($Response);
});

/***************************************************************************************
 * Routing Table - End
 ***************************************************************************************/

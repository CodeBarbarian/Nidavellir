<?php

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

/***************************************************************************************
 * Routing Table - End
 ***************************************************************************************/

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
	$Response = array("status" => 200);

	echo json_encode($Response);
});

/***************************************************************************************
 * Routing Table - End
 ***************************************************************************************/

<?php
/***************************************************************************************
 * @Name: Default.php
 * @Type: Route
 * @Description: Default route of the application. This is one of the many route files.
 *               This is used to show that code, and routes can be divided among more
 *               files, and if necessary all the routes can also be in one single file.
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

Heimdall::get('{controller}/{action}');

/***************************************************************************************
 * Routing Table - End
 ***************************************************************************************/

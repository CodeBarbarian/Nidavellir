<?php
/***************************************************************************************
 * @Name: Routes.php
 * @Type: Route
 * @Description: Routes. This is one of the many route files.
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

Heimdall::get('', ['controller' => "Home", 'action' => 'index']);
Heimdall::get('/', ['controller' => "Home", 'action' => 'index']);

Heimdall::get('dashboard', ['controller' => "Home", 'action' => 'index']);
Heimdall::get('/user/logout', ['controller' => "User", 'action' => 'logout']);
Heimdall::get('/user/profile', ['controller' => "User", 'action' => 'profile']);

/***************************************************************************************
 * Routing Table - End
 ***************************************************************************************/

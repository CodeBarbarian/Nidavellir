<?php

namespace App\Route;

use Core\Forge\Routers\Router;

$Router = new Router();
/***************************************************************************************
 * Routing Table - Begin
 ***************************************************************************************/
// Standard Routing
$Router->add('', ['controller' => 'Home', 'action' => 'index']);
$Router->add('/', ['controller' => 'Home', 'action' => 'index']);

// Default Route
$Router->add('{controller}/{action}');
/***************************************************************************************
 * Routing Table - End
 ***************************************************************************************/

// Router Dispatch
$Router->dispatch($_SERVER['QUERY_STRING']);
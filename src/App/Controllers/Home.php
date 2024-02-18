<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

use Core\Forge\Queues\Message;

class Home extends Controller {
	public function indexAction() : void {
		Message::addMessage("Message Queue Works?");
		View::renderTemplate('Home/index.html');
	}

}
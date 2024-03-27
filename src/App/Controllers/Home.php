<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

class Home extends Controller {
	public function indexAction() : void {
		View::renderTemplate('Home/index.html');
	}
}
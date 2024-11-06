<?php

namespace App\Controllers;

use App\Models\HomeModel;
use Core\Controller;
use Core\View;

class Home extends Controller {
	public function indexAction() : void {
		View::renderTemplate('Home/index.html');
	}
}
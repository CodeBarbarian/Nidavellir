<?php

namespace App\Controllers;

use App\Models\HomeModel;
use Core\Controller;
use Core\View;

class Home extends Controller {
	public function indexAction() : void {
        $Output = HomeModel::test();
		View::renderTemplate('Home/index.html', ['test' => $Output]);
	}

    public function runAction() : void {
        // Get the ID
        $Params = $this->route_params['id'];


    }
}
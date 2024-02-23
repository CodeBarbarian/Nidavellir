<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Forge\Queues\Message;
use Core\Forge\Queues\Queue;

class Home extends Controller {
	public function indexAction() : void {
		Message::addMessage("Message Queue Works?");
		View::renderTemplate('Home/index.html');
	}

	public static function testAction() : void {

		Queue::setOrder("FILO");


		Queue::Enqueue("First Item");
		Queue::Enqueue("Second Item");
		Queue::Enqueue("Third Item");
		Queue::Enqueue("Fourth Item");

		var_dump(Queue::Dequeue());
		var_dump(Queue::Peek());
		var_dump(Queue::Dequeue());
		var_dump(Queue::Dequeue());
		var_dump(Queue::Dequeue());
	}

}
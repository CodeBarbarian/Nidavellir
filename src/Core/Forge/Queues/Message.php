<?php

namespace Core\Forge\Queues;

class Message {
	/**
	 * Success message type
	 * @var string
	 */
	const SUCCESS = 'success';

	/**
	 * Information message type
	 * @var string
	 */
	const INFO = 'info';

	/**
	 * Warning message type
	 * @var string
	 */
	const WARNING = 'warning';

	/**
	 * Danger message type
	 * @var string
	 */
	const DANGER = 'danger';

	/**
	 * Add a message
	 *
	 * @param string $Message
	 * @param string $Type
	 * @return void
	 */
	public static function addMessage(string $Message, string $Type = 'success'): void {
		// Create array in the session if it doesn't already exist
		if (!isset($_SESSION['flash_notifications'])) {
			$_SESSION['flash_notifications'] = [];
		}

		// Append the message to the array
		$_SESSION['flash_notifications'][] = [
			'body' => $Message,
			'type' => $Type
		];
	}

	/**
	 * Get all the messages
	 *
	 * @return array|bool An array with all the messages or null if none set
	 */
	public static function getMessages(): array|bool {
		if (isset($_SESSION['flash_notifications'])) {
			$Messages = $_SESSION['flash_notifications'];
			unset($_SESSION['flash_notifications']);

			return $Messages;
		}

		return false;
	}
}
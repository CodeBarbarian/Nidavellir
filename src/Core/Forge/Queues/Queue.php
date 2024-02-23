<?php

namespace Core\Forge\Queues;

class Queue {
	private static string $Order = "FIFO";
	private static array $Queue = [];

	/**
	 * Set the order of the queue
	 *
	 * @param string $Order {FIFO|FILO}
	 * @return void
	 */
	public static function setOrder(string $Order = "FIFO"): void {
		static::$Order = match ($Order) {
			'FILO' => "FILO",
			"FIFO" => "FIFO",
		};
	}

	/**
	 * Check if queue is empty
	 *
	 * @return bool
	 */
	public static function isEmpty(): bool {
		return empty(static::$Queue);
	}

	/**
	 * Enqueue item
	 *
	 * @param $Item
	 * @return void
	 */
	public static function Enqueue ($Item): void {
		static::$Queue[] = $Item;
	}

	/**
	 * Dequeue item
	 *
	 * @return mixed|void|null
	 */
	public static function Dequeue()  {
		if (!static::isEmpty()) {
			return (static::$Order === "FIFO") ? array_shift(static::$Queue) : array_pop(static::$Queue);
		}
	}

	/**
	 * Look at the first item in the queue
	 * @return mixed|void
	 */
	public static function Peek() {
		if (!static::isEmpty()) {
			return (static::$Order === "FIFO") ? static::$Queue[0] : (array_reverse(static::$Queue))[0];
		}
	}
}
<?php

namespace App\Config;

use Core\Config;

/**
 * Site Config
 * @version: PHP: 8.1
 *
 * @Site
 */
class Site extends Config {
	/**
	 * HTTP vs HTTPS
	 * @var boolean
	 * */
	const SECURE_SERVER_COMMUNICATION = false;

	/**
	 * System Environment
	 * Values supported:
	 *      - development
	 *      - production
	 *
	 * @var string
	 */
	const SYSTEM_ENVIRONMENT = 'production';
}
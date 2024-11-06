<?php

namespace App\Config;

use Core\Config;

/**
 * Paths Config
 * @version: PHP: 8.1
 *
 * @Paths
 */
class Paths extends Config {
	/**
	 * Get HTTP HOST, with correct SSL settings
	 *
	 * @return string
	 */
	public static function SITE_ROOT() : string {
		return ((Site::SECURE_SERVER_COMMUNICATION) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
	}

	/**
	 * Core directory
	 * @var string
	 */
	const CORE_DIR = 'Core';

	const FORGE_DIR = self::CORE_DIR . '/Forge';

	const MIDDLEWARE_DIR = self::FORGE_DIR . '/Middleware';

	/**
	 * System directory
	 * @var string
	 */
	const SYSTEM_DIR = self::CORE_DIR . '/System';

	/**
	 * Log directory
	 * @var string
	 */
	const SYSTEM_LOGS = 'logs';

	/**
	 * Localization Directory
	 * @var string
	 */
	const LOCALIZATION_DIR = self::CORE_DIR . '/Localization';

	/**
	 * Plugin directory
	 * @var string
	 */
	const PLUGIN_DIR = self::CORE_DIR . '/Plugins';

	/**
	 * Language directory
	 * @var string
	 */
	const LANGUAGE_DIR = self::LOCALIZATION_DIR . '/Languages';

	/**
	 * Application directory
	 * @var string
	 */
	const APPLICATION_DIR = 'App';

	/**
	 * Policy directory
	 * @var string
	 */
	const POLICY_DIR = self::CORE_DIR . '/Policies';

	/**
	 * Controller directory
	 * @var string
	 */
	const CONTROLLER_DIR = self::APPLICATION_DIR . '/Controllers';

	/**
	 * Model directory
	 * @var string
	 */
	const MODEL_DIR = self::APPLICATION_DIR . '/Models';

	/**
	 * Views directory
	 * @var string
	 */
	const VIEW_DIR = self::APPLICATION_DIR . '/Views';

	/**
	 * Cache Directory
	 * @var string
	 */
	const CACHE_DIR = self::APPLICATION_DIR . '/Cache';
}
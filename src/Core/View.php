<?php

namespace Core;

use App\Config\Paths;
use Core\Forge\Queues\Message;
use Core\Forge\Template\TinyTemplate\TinyTemplate;
use Core\Forge\System\System;


/**
 * View
 * @version: PHP: 8.2
 *
 * @View
 */
class View
{
	/**
	 * Render a view file
	 *
	 * @param string $View
	 * @param array $Args
	 * @return void
	 * @throws \Exception
	 */
	public static function render(string $View, array $Args = []): void
	{
		extract($Args, EXTR_SKIP);

		$File = sprintf("%s/App/Views/$View", dirname(__DIR__));  // relative to Core directory

		if (is_readable($zFile)) {
			require $File;
		} else {
			throw new \Exception("$File not found");
		}
	}

	public static function renderTemplate(string $Template, array $Args = []) : void {
		echo static::getTemplate($Template, $Args);
	}

	/**
	 * @throws \Exception
	 */
	public static function getTemplate(string $Template, array $Args = []): bool
	{
		static $Tiny = null;

		if ($Tiny === null) {
			$Tiny = new TinyTemplate();
			$Tiny->setViewsDirectory(dirname(__DIR__) . '/App/Views');
			$Tiny->setCacheDirectory(dirname(__DIR__) . '/App/Storage/Cache');

			/**
			 * Template Variables
			 */
			$Tiny->setGlobal("public_root", Paths::SITE_ROOT());
			$Tiny->setGlobal("flash_message", Message::getMessages());

            // Only to be able to manipulate the output if needed
            // @todo: this needs to be fixed somehow. Must be more elegant!
            $Tiny->setGlobal("framework_version", System::getFrameworkVersion());
		}

		/**
		 * Render the template view
		 */
		if (!empty($Template)) {
			$Tiny->View($Template, $Args);
		}

		return false;
	}
}
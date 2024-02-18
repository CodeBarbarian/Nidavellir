<?php

namespace Core\Forge\Template\TinyTemplate;

use Core\Forge\Template\TinyTemplate\TinyTemplateConfig;

/**
 * TinyTemplate Engine
 */
class TinyTemplate
{
	static array $Blocks = array();
	static string $ViewDirectory = "";
	static string $CacheDirectory = "";
	static array $TemplateGlobals = array();

	/**
	 * Class construct, for future use.
	 */
	public function __construct() {}

	public function setViewsDirectory($Path) : void
	{
		self::$ViewDirectory = $Path;
	}

	public function setCacheDirectory($Path) : void
	{
		self::$CacheDirectory = $Path;
	}

	public function setGlobal($Name, $Value): void
	{
		self::$TemplateGlobals[$Name] = $Value;
	}

	/**
	 * View a template
	 *
	 * @param string $File
	 * @param array $Args
	 * @return void
	 * @throws \Exception
	 */
	public static function View(string $File, array $Args = []): void
	{
		// Make sure we can use our global template variables
		$Args = array_merge($Args, self::$TemplateGlobals);
		$File = '/' . $File;
		$CachedFile = self::Cache($File);
		extract($Args, EXTR_SKIP);

		require $CachedFile;
	}

	/**
	 * @param $File
	 * @return array|string|null
	 */
	private static function IncludeFiles($File): array|string|null
	{
		$Code = file_get_contents($File);
		preg_match_all('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', $Code, $Matches, PREG_SET_ORDER);

		foreach ($Matches as $Value) {
			$Code = str_replace($Value[0], self::IncludeFiles(self::$ViewDirectory . '/' . $Value[2]), $Code);
		}

		return preg_replace('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', '', $Code);
	}

	/**
	 * @param $Code
	 * @return array|mixed|string|string[]
	 */
	private static function CompileBlock($Code): mixed
	{
		preg_match_all('/{% ?block ?(.*?) ?%}(.*?){% ?endblock ?%}/is', $Code, $Matches, PREG_SET_ORDER);

		foreach ($Matches as $Value) {
			if (!array_key_exists($Value[1], self::$Blocks)) self::$Blocks[$Value[1]] = '';

			if (!str_contains($Value[2], '@parent')) {
				self::$Blocks[$Value[1]] = $Value[2];
			} else {
				self::$Blocks[$Value[1]] = str_replace('@parent', self::$Blocks[$Value[1]], $Value[2]);
			}

			$Code = str_replace($Value[0], '', $Code);
		}

		return $Code;
	}

	/**
	 * @param $Code
	 * @return array|string|null
	 */
	private static function CompileYield($Code): array|string|null
	{
		foreach (self::$Blocks as $Block => $Value) {
			$Code = preg_replace('/{% ?yield ?' . $Block . ' ?%}/', $Value, $Code);
		}

		return preg_replace('/{% ?yield ?(.*?) ?%}/i', '', $Code);
	}

	/**
	 * @param $Code
	 * @return array|string|null
	 */
	private static function CompileEscapedEchos($Code): array|string|null
	{
		return preg_replace('~\{{{\s*(.+?)\s*}}\}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $Code);
	}

	/**
	 * @param $Code
	 * @return array|string|null
	 */
	private static function CompileEchos($Code): array|string|null
	{
		return preg_replace('~\{{\s*(.+?)\s*}\}~is', '<?php echo $1 ?>', $Code);
	}

	/**
	 * Build the PHP Code within the file
	 *
	 * @param $Code
	 * @return array|string|null
	 */
	private static function CompilePHP($Code): array|string|null
	{
		return preg_replace('~\{%\s*(.+?)\s*%\}~is', '<?php $1 ?>', $Code);
	}

	/**
	 * Builds the file in the correct order
	 *
	 * @param $Code
	 * @return array|string|null
	 */
	private static function CompileCode($Code): array|string|null
	{
		$Code = self::CompileBlock($Code);
		$Code = self::CompileYield($Code);
		$Code = self::CompileEscapedEchos($Code);
		$Code = self::CompileEchos($Code);
		return self::CompilePHP($Code);
	}

	/**
	 * @param string $File
	 * @return bool|string|null
	 * @throws \Exception
	 */
	public static function Cache(string $File): bool|string|null
	{
		if (!file_exists(static::$CacheDirectory)) {
			throw new \Exception("Cache directory does not exist.");
		}

		// Build the Cache File _Controller_Action.php
		$CachedFile = static::$CacheDirectory . '/' . str_replace(array('/', '.html'), array('_', ''), $File . '.php');

		// Build the filepath for the source files
		$File = self::$ViewDirectory . $File;

		// If we have caching enabled, use the previous files, if not generate new ones.
		if (!TinyTemplateConfig::CACHE_ENABLED || !file_exists($CachedFile) || filemtime($CachedFile) < filemtime($CachedFile)) {
			$Code = self::IncludeFiles($File);
			$Code = self::CompileCode($Code);

			file_put_contents($CachedFile, '<?php class_exists(\'' . __CLASS__ . '\') or exit; ?>' . PHP_EOL . $Code);
		}

		// Return Cached File
		return $CachedFile;
	}

	/**
	 * Unlink files in the cache directory.
	 * @param $CacheDirectory
	 * @return void
	 */
	public static function ClearCache($CacheDirectory ): void
	{
		foreach(glob($CacheDirectory . '*') as $File) {
			unlink($File);
		}
	}
}
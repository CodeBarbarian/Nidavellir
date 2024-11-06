<?php

namespace Core\Forge\Template\TinyTemplate;

use Exception;

class TinyTemplate
{
    private array $blocks = [];
    private string $viewDirectory = "";
    private string $cacheDirectory = "";
    private array $templateGlobals = [];

    /**
     * Set the directory for view templates.
     *
     * @param string $path
     */
    public function setViewsDirectory(string $path): void
    {
        $this->viewDirectory = rtrim($path, '/');
    }

    /**
     * Set the directory for cached templates.
     *
     * @param string $path
     */
    public function setCacheDirectory(string $path): void
    {
        $this->cacheDirectory = rtrim($path, '/');
    }

    /**
     * Set a global variable accessible in all templates.
     *
     * @param string $name
     * @param mixed $value
     */
    public function setGlobal(string $name, mixed $value): void
    {
        $this->templateGlobals[$name] = $value;
    }

    /**
     * Render a template view.
     *
     * @param string $file
     * @param array $args
     * @throws Exception
     */
    public function view(string $file, array $args = []): void
    {
        $args = array_merge($args, $this->templateGlobals);
        $filePath = '/' . $file;
        $cachedFile = $this->cache($filePath);

        extract($args, EXTR_SKIP);
        require $cachedFile;
    }

    /**
     * Recursively include files for "extends" or "include" in templates.
     *
     * @param string $file
     * @return string
     * @throws Exception
     */
    private function includeFiles(string $file): string
    {
        if (!file_exists($file)) {
            throw new Exception("File '$file' not found.");
        }

        $code = file_get_contents($file);
        preg_match_all('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', $code, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $code = str_replace($match[0], $this->includeFiles($this->viewDirectory . '/' . $match[2]), $code);
        }

        return preg_replace('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', '', $code);
    }

    /**
     * Compile blocks in the template code.
     *
     * @param string $code
     * @return string
     */
    private function compileBlock(string $code): string
    {
        preg_match_all('/{% ?block ?(.*?) ?%}(.*?){% ?endblock ?%}/is', $code, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $this->blocks[$match[1]] = str_contains($match[2], '@parent')
                ? str_replace('@parent', $this->blocks[$match[1]] ?? '', $match[2])
                : $match[2];
            $code = str_replace($match[0], '', $code);
        }

        return $code;
    }

    /**
     * Replace "yield" blocks in the template code.
     *
     * @param string $code
     * @return string
     */
    private function compileYield(string $code): string
    {
        foreach ($this->blocks as $block => $value) {
            $code = preg_replace('/{% ?yield ?' . $block . ' ?%}/', $value, $code);
        }

        return preg_replace('/{% ?yield ?(.*?) ?%}/i', '', $code);
    }

    /**
     * Compile escaped echos in the template code.
     *
     * @param string $code
     * @return string
     */
    private function compileEscapedEchos(string $code): string
    {
        return preg_replace('~\{{{\s*(.+?)\s*}}}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $code);
    }

    /**
     * Compile unescaped echos in the template code.
     *
     * @param string $code
     * @return string
     */
    private function compileEchos(string $code): string
    {
        return preg_replace('~\{{\s*(.+?)\s*}}~is', '<?php echo $1 ?>', $code);
    }

    /**
     * Compile PHP code blocks in the template code.
     *
     * @param string $code
     * @return string
     */
    private function compilePHP(string $code): string
    {
        return preg_replace('~\{%\s*(.+?)\s*%}~is', '<?php $1 ?>', $code);
    }

    /**
     * Compile the template code by processing blocks, yields, and echos.
     *
     * @param string $code
     * @return string
     */
    private function compileCode(string $code): string
    {
        $code = $this->compileBlock($code);
        $code = $this->compileYield($code);
        $code = $this->compileEscapedEchos($code);
        $code = $this->compileEchos($code);
        return $this->compilePHP($code);
    }

    /**
     * Cache the compiled template code.
     *
     * @param string $file
     * @return string Path to the cached file
     * @throws Exception
     */
    public function cache(string $file): string
    {
        if (!is_dir($this->cacheDirectory)) {
            throw new Exception("Cache directory does not exist.");
        }

        $cachedFile = $this->cacheDirectory . '/' . str_replace(['/', '.html'], ['_', ''], $file) . '.php';
        $sourceFile = $this->viewDirectory . $file;

        if (!TinyTemplateConfig::CACHE_ENABLED || !file_exists($cachedFile) || filemtime($sourceFile) > filemtime($cachedFile)) {
            $code = $this->includeFiles($sourceFile);
            $compiledCode = $this->compileCode($code);

            if (file_put_contents($cachedFile, '<?php class_exists(\'' . __CLASS__ . '\') or exit; ?>' . PHP_EOL . $compiledCode) === false) {
                throw new Exception("Failed to write to cache file '$cachedFile'.");
            }
        }

        return $cachedFile;
    }

    /**
     * Clear the cache directory.
     *
     * @param string|null $cacheDirectory
     */
    public function clearCache(?string $cacheDirectory = null): void
    {
        $cacheDirectory = $cacheDirectory ?? $this->cacheDirectory;
        foreach (glob(rtrim($cacheDirectory, '/') . '/*') as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}

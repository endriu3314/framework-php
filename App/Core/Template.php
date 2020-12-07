<?php

namespace App\Core;

class Template
{
    public static array $blocks = [];
    public static string $cache_path = ROOT . 'public' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;
    public static bool $cache_enabled = ! (ENVIRONMENT === 'development' || ENVIRONMENT === 'dev');

    public static function view($file, $data = []): void
    {
        $cached_file = self::cache($file);
        extract($data, EXTR_SKIP);
        require $cached_file;
    }

    public static function cache($file): string
    {
        if (
            ! file_exists(self::$cache_path) &&
            ! mkdir($concurrentDirectory = self::$cache_path, 0744) &&
            ! is_dir($concurrentDirectory)
        ) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }

        $cached_file = self::$cache_path . str_replace(['/', '.html'], ['_', ''], $file . '.php');

        if (
            ! self::$cache_enabled ||
            ! file_exists($cached_file) ||
            filemtime($cached_file) < filemtime(ROOT . 'templates\\' . $file)
        ) {
            $code = self::includeFiles($file);
            $code = self::compileCode($code);
            file_put_contents($cached_file, '<?php class_exists(\'' . __CLASS__ . '\') or exit; ?>' . PHP_EOL . $code);
        }

        return $cached_file;
    }

    public static function clearCache(): void
    {
        foreach (glob(self::$cache_path . '*') as $file) {
            unlink($file);
        }
    }

    public static function compileCode($code): array | string | null
    {
        $code = self::compileBlock($code);
        $code = self::compileYield($code);
        $code = self::compileEscapedEchos($code);
        $code = self::compileEchos($code);
        $code = self::compilePHP($code);

        return $code;
    }

    public static function includeFiles($file): array | string | null
    {
        $code = file_get_contents(ROOT . 'templates' . DIRECTORY_SEPARATOR . $file);
        preg_match_all('/{# ?(extends|include) ?\'?(.*?)\'? ?#}/i', $code, $matches, PREG_SET_ORDER);

        foreach ($matches as $value) {
            $code = str_replace($value[0], self::includeFiles($value[2]), $code);
        }

        $code = preg_replace('/{# ?(extends|include) ?\'?(.*?)\'? ?#}/i', '', $code);

        return $code;
    }

    public static function compilePHP($code): array | string | null
    {
        return preg_replace('~\{#\s*(.+?)\s*\#}~is', '<?php $1 ?>', $code);
    }

    public static function compileEchos($code): array | string | null
    {
        return preg_replace('~\{{\s*(.+?)\s*\}}~is', '<?php echo $1 ?>', $code);
    }

    public static function compileEscapedEchos($code): array | string | null
    {
        return preg_replace('~\{{{\s*(.+?)\s*\}}}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $code);
    }

    public static function compileBlock($code)
    {
        preg_match_all('/{# ?block ?(.*?) ?#}(.*?){# ?endblock ?#}/is', $code, $matches, PREG_SET_ORDER);

        foreach ($matches as $value) {
            if (! array_key_exists($value[1], self::$blocks)) {
                self::$blocks[$value[1]] = '';
            }

            if (! str_contains($value[2], '@parent')) {
                self::$blocks[$value[1]] = $value[2];
            } else {
                self::$blocks[$value[1]] = str_replace('@parent', self::$blocks[$value[1]], $value[2]);
            }

            $code = str_replace($value[0], '', $code);
        }

        return $code;
    }

    public static function compileYield($code): array | string | null
    {
        foreach (self::$blocks as $block => $value) {
            $code = preg_replace('/{# ?yield ?' . $block . ' ?#}/', $value, $code);
        }

        $code = preg_replace('/{# ?yield ?(.*?) ?#}/i', '', $code);

        return $code;
    }
}

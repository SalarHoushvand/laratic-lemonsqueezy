<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ExtractTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Usage:
     *  php artisan translations:extract
     *  php artisan translations:extract --lang=fr
     *  php artisan translations:extract --paths=app --paths=resources/views
     *  php artisan translations:extract --dry-run
     */
    protected $signature = 'translations:extract
        {--lang=en : Target language (resources/lang/<lang>.json)}
        {--paths=* : Limit scan to one or more directories}
        {--dry-run : Only show keys without writing any files}';

    /**
     * The console command description.
     */
    protected $description = 'Scan the codebase for translatable strings and update the language JSON file.';

    public function __construct(protected Filesystem $files)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $lang = $this->option('lang') ?: 'en';
        $paths = $this->option('paths');

        // Default paths to scan
        if (empty($paths)) {
            $paths = [
                app_path(),
                resource_path('views'),
            ];
        }

        $this->info('Scanning directories:');
        foreach ($paths as $path) {
            $this->line('  • '.$path);
        }

        $files = $this->getFiles($paths);
        $keys = $this->extractKeysFromFiles($files);

        $this->newLine();
        $this->info('Found '.count($keys).' unique translation keys.');

        if ($this->option('dry-run')) {
            $this->newLine();
            foreach ($keys as $key) {
                $this->line($key);
            }

            return self::SUCCESS;
        }

        // Determine lang file path (lang_path exists in modern Laravel)
        if (function_exists('lang_path')) {
            $langFile = lang_path("{$lang}.json");
        } else {
            $langFile = resource_path("lang/{$lang}.json");
        }

        $this->files->ensureDirectoryExists(dirname($langFile));

        $existing = [];
        if ($this->files->exists($langFile)) {
            $existing = json_decode($this->files->get($langFile), true) ?: [];
        }

        // Merge new keys into existing translations
        foreach ($keys as $key) {
            if (! array_key_exists($key, $existing)) {
                $existing[$key] = null; // default value = null to mark as untranslated
            }
        }

        ksort($existing);

        $this->files->put(
            $langFile,
            json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );

        $this->newLine();
        $this->info("Language file updated: {$langFile}");
        $this->info('Total entries: '.count($existing));

        return self::SUCCESS;
    }

    /**
     * Get all scannable files from the given paths.
     *
     * @param  array<int, string>  $paths
     * @return array<int, \Symfony\Component\Finder\SplFileInfo>
     */
    protected function getFiles(array $paths): array
    {
        $allFiles = [];

        foreach ($paths as $path) {
            if (! $this->files->isDirectory($path)) {
                continue;
            }

            foreach ($this->files->allFiles($path) as $file) {
                if (! $this->isScannable($file->getPathname())) {
                    continue;
                }

                $allFiles[] = $file;
            }
        }

        return $allFiles;
    }

    /**
     * Decide if a file should be scanned.
     */
    protected function isScannable(string $path): bool
    {
        // Skip vendor, storage, node_modules, bootstrap, etc.
        $ignoreSegments = [
            DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR,
            DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR,
            DIRECTORY_SEPARATOR.'node_modules'.DIRECTORY_SEPARATOR,
            DIRECTORY_SEPARATOR.'bootstrap'.DIRECTORY_SEPARATOR,
        ];

        foreach ($ignoreSegments as $segment) {
            if (str_contains($path, $segment)) {
                return false;
            }
        }

        $filename = basename($path);

        // Only PHP & Blade files
        return str_ends_with($filename, '.php') || str_ends_with($filename, '.blade.php');
    }

    /**
     * Extract unique keys from a set of files.
     *
     * @param  array<int, \Symfony\Component\Finder\SplFileInfo>  $files
     * @return array<int, string>
     */
    protected function extractKeysFromFiles(array $files): array
    {
        $keys = [];

        foreach ($files as $file) {
            $content = $this->files->get($file->getRealPath());

            foreach ($this->extractKeysFromString($content) as $key) {
                $keys[$key] = true;
            }
        }

        $uniqueKeys = array_keys($keys);
        sort($uniqueKeys);

        return $uniqueKeys;
    }

    /**
     * Extract translation keys from the contents of a single file.
     *
     * Looks for:
     *   __('key')
     *
     *   @lang('key')
     *
     *   @choice('key', $count)
     *   trans('key')
     *   Lang::get('key')
     *
     * Only literal string keys are supported (dynamic variables are ignored).
     */
    protected function extractKeysFromString(string $content): array
    {
        $patterns = [
            // __("...")
            '/\b__\(\s*(["\'])(.*?)\1/s',

            // @lang("...")
            '/@lang\(\s*(["\'])(.*?)\1/s',

            // @choice("...", $count)
            '/@choice\(\s*(["\'])(.*?)\1\s*,/s',

            // trans("...")
            '/\btrans\(\s*(["\'])(.*?)\1/s',

            // Lang::get("...")
            '/\bLang::get\(\s*(["\'])(.*?)\1/s',
        ];

        $keys = [];

        foreach ($patterns as $pattern) {
            if (preg_match_all($pattern, $content, $matches)) {
                foreach ($matches[2] as $match) {
                    $keys[] = $match;
                }
            }
        }

        return $keys;
    }
}

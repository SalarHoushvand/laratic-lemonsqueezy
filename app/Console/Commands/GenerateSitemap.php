<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml file';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating sitemap...');

        $sitemap = Sitemap::create();

        // Add public static routes (automatically discovered)
        $staticCount = $this->addPublicRoutes($sitemap);

        // Add documentation pages
        $docsPath = resource_path('views/pages/docs');
        $docCount = $this->addDocumentationPages($sitemap, $docsPath);

        // Add active blog posts
        $posts = Post::active()->get();
        $postCount = $posts->count();

        $posts->each(function (Post $post) use ($sitemap) {
            $sitemap->add(
                Url::create(route('posts.show', $post->slug))
                    ->setLastModificationDate($post->updated_at)
                    ->setPriority(0.7)
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $totalCount = $staticCount + $docCount + $postCount;

        $this->info('Sitemap generated successfully!');
        $this->line("Total URLs: {$totalCount} ({$staticCount} static pages, {$docCount} documentation pages, {$postCount} blog posts)");
        $this->line('Sitemap saved to: '.public_path('sitemap.xml'));

        return 0;
    }

    /**
     * Automatically discover and add all public routes to sitemap.
     */
    protected function addPublicRoutes(Sitemap $sitemap): int
    {
        $count = 0;
        $routes = \Illuminate\Support\Facades\Route::getRoutes();

        // Define priority mapping for specific routes
        $priorityMap = [
            'home' => 1.0,
            'pricing' => 0.9,
            'features' => 0.8,
            'blog' => 0.8,
            'careers' => 0.7,
            'about-us' => 0.7,
            'contact' => 0.7,
            'waitlist' => 0.6,
            'terms' => 0.5,
            'privacy' => 0.5,
        ];

        foreach ($routes as $route) {
            // Skip if route doesn't have a name
            if (! $route->getName()) {
                continue;
            }

            // Skip routes that should not be in sitemap
            if ($this->shouldSkipRoute($route)) {
                continue;
            }

            // Skip routes with required parameters (except those handled separately like blog posts)
            if ($this->routeHasRequiredParameters($route)) {
                continue;
            }

            try {
                $url = route($route->getName());
                $priority = $priorityMap[$route->getName()] ?? 0.6;

                $sitemap->add(
                    Url::create($url)->setPriority($priority)
                );

                $count++;
            } catch (\Exception $e) {
                // Skip routes that can't be generated
                continue;
            }
        }

        return $count;
    }

    /**
     * Determine if a route should be skipped from the sitemap.
     */
    protected function shouldSkipRoute(\Illuminate\Routing\Route $route): bool
    {
        $name = $route->getName();
        $uri = $route->uri();

        // Skip routes that start with underscore (internal routes like _boost, _debugbar, etc.)
        if (str_starts_with($uri, '_')) {
            return true;
        }

        // Skip debugbar routes
        if (str_starts_with($name, 'debugbar.')) {
            return true;
        }

        // Skip Laravel Boost routes
        if (str_starts_with($name, 'laravel-boost.') || str_contains($uri, '_boost')) {
            return true;
        }

        // Skip webhook routes
        if (str_contains($name, 'webhook') || str_contains($name, 'lemon-squeezy.')) {
            return true;
        }

        // Skip API routes
        if (str_starts_with($name, 'api.')) {
            return true;
        }

        // Skip auth routes
        if (str_starts_with($name, 'password.') ||
            str_starts_with($name, 'verification.') ||
            in_array($name, ['login', 'register', 'logout'])) {
            return true;
        }

        // Skip socialite OAuth routes
        if (str_contains($uri, 'auth/google') ||
            str_contains($uri, 'auth/github') ||
            str_contains($uri, 'auth/') && (str_contains($uri, '/redirect') || str_contains($uri, '/callback'))) {
            return true;
        }

        // Skip error test pages
        if (str_contains($uri, 'test/errors')) {
            return true;
        }

        // Skip admin routes
        if (str_starts_with($name, 'admin.')) {
            return true;
        }

        // Skip authenticated routes
        if (str_starts_with($name, 'settings.') ||
            str_starts_with($name, 'plans.') ||
            str_starts_with($name, 'subscription.') ||
            str_starts_with($name, 'products.') ||
            str_starts_with($name, 'orders.') ||
            str_starts_with($name, 'ai.') ||
            $name === 'dashboard') {
            return true;
        }

        // Skip documentation routes (handled separately with file scanning)
        if ($name === 'docs.show') {
            return true;
        }

        // Skip individual blog post routes (handled separately with database query)
        if ($name === 'posts.show') {
            return true;
        }

        // Skip Livewire routes
        if (str_contains($name, 'livewire.')) {
            return true;
        }

        // Check middleware for auth requirements
        $middleware = $route->gatherMiddleware();
        foreach ($middleware as $mw) {
            if (is_string($mw) && (str_contains($mw, 'auth') || str_contains($mw, 'role') || str_contains($mw, 'subscribed'))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if route has required parameters.
     */
    protected function routeHasRequiredParameters(\Illuminate\Routing\Route $route): bool
    {
        $parameters = $route->parameterNames();

        return count($parameters) > 0;
    }

    /**
     * Recursively scan documentation directory and add all documentation pages to sitemap.
     */
    protected function addDocumentationPages(Sitemap $sitemap, string $docsPath, string $prefix = ''): int
    {
        $count = 0;

        if (! File::exists($docsPath)) {
            return $count;
        }

        $items = File::files($docsPath);
        $directories = File::directories($docsPath);

        // Add blade files in current directory
        foreach ($items as $file) {
            if ($file->getExtension() === 'php') {
                // Remove .blade.php extension to get the clean filename
                $filename = $file->getFilenameWithoutExtension();
                $filename = str_replace('.blade', '', $filename);
                $topic = $prefix ? "{$prefix}/{$filename}" : $filename;

                // Skip index files as they're typically accessed via parent path
                if ($filename === 'index' && $prefix) {
                    continue;
                }

                $sitemap->add(
                    Url::create(route('docs.show', $topic))
                        ->setPriority(0.6)
                );
                $count++;
            }
        }

        // Recursively process subdirectories
        foreach ($directories as $directory) {
            $dirName = basename($directory);
            $newPrefix = $prefix ? "{$prefix}/{$dirName}" : $dirName;
            $count += $this->addDocumentationPages($sitemap, $directory, $newPrefix);
        }

        return $count;
    }
}

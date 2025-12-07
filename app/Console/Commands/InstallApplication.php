<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan app:install
     */
    protected $signature = 'app:install 
                            {--force : Overwrite existing .env and run commands in force mode}';

    /**
     * The console command description.
     */
    protected $description = 'Set up the application (env file, key, migrations, etc.)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Starting application installation...');

        $this->setupEnvFile();
        $this->generateAppKey();
        $this->runMigrations();
        $this->createStorageLink();
        $this->clearAndCache();

        $this->info('✅ Installation completed successfully!');

        return self::SUCCESS;
    }

    protected function setupEnvFile(): void
    {
        $envPath = base_path('.env');
        $examplePath = base_path('.env.example');

        if (File::exists($envPath) && ! $this->option('force')) {
            $this->line('➡️  .env already exists. Skipping copy (use --force to overwrite).');
            return;
        }

        if (! File::exists($examplePath)) {
            $this->error('❌ .env.example not found.');
            return;
        }

        File::copy($examplePath, $envPath);
        $this->info('✅ .env file created from .env.example');
    }

    protected function generateAppKey(): void
    {
        $this->info('🔑 Generating app key...');
        Artisan::call('key:generate', [
            '--force' => $this->option('force'),
        ]);

        $this->line(Artisan::output());
    }

    protected function runMigrations(): void
    {
        if (! $this->confirm('🗄  Run migrations and seed database now?', true)) {
            $this->line('⏭  Skipping migrations.');
            return;
        }

        $this->info('🗄  Running migrations and seeders...');

        Artisan::call('migrate', [
            '--seed' => true,
            '--force' => $this->option('force'),
        ]);

        $this->line(Artisan::output());
    }

    protected function createStorageLink(): void
    {
        $this->info('🔗 Creating storage symlink (storage:link)...');

        Artisan::call('storage:link');
        $this->line(Artisan::output());
    }

    protected function clearAndCache(): void
    {
        $this->info('🧹 Clearing and caching app...');

        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        Artisan::call('config:cache');
        Artisan::call('route:cache');

        $this->line('✅ Caches cleared and rebuilt. Welcome to 🐧Laravel!');
    }
}

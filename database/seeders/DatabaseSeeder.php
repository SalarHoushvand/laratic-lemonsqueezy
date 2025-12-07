<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * By default, runs the DemoSeeder (500 users).
     *
     * To use different seeders:
     * - Minimal (10 users): php artisan db:seed --class=MinimalSeeder
     * - Demo (500 users): php artisan db:seed --class=DemoSeeder
     * - Heavy (10,000 users): php artisan db:seed --class=HeavySeeder
     */
    public function run(): void
    {
        $this->call([
            DemoSeeder::class,
        ]);
    }
}

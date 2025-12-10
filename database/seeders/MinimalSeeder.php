<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MinimalSeeder extends Seeder
{
    /**
     * Seed the database with minimal data for starting the project.
     *
     * Includes:
     * - 1 admin user
     * - 10 regular users
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting MINIMAL seeding...');

        $this->call([
            RoleSeeder::class,
        ]);

        $this->command->info('Creating users...');
        $this->call(UserSeeder::class, false, [
            'userCount' => 10,
            'createAdmin' => true,
        ]);

        $this->command->info('✅ MINIMAL seeding completed!');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HeavySeeder extends Seeder
{
    /**
     * Seed the database with heavy load data for stress testing.
     *
     * Includes:
     * - 1 admin user
     * - 10,000 regular users
     * - All products and plans from CSV
     * - 2 tags with translations
     * - All blog posts from CSV
     * - Extensive AI usage (20-50 per user = ~350,000 records)
     * - Many subscriptions (~40% of users = ~4,000)
     * - Many orders (~30% of users, 2-6 orders each = ~12,000 orders)
     * - Corresponding transactions (~50,000+)
     *
     * WARNING: This will take several minutes to complete and create
     * a large database (~500MB+). Use for performance testing only.
     */
    public function run(): void
    {
        $this->command->info('⚡ Starting HEAVY seeding...');
        $this->command->warn('This will take several minutes. Please be patient.');

        $startTime = now();

        $this->call([
            RoleSeeder::class,
        ]);

        $this->command->info('Creating users (this will take a few minutes)...');
        $this->call(UserSeeder::class, false, [
            'userCount' => 5000,
            'createAdmin' => true,
        ]);

        $this->call([
            ProductSeeder::class,
            PlanSeeder::class,
            TagSeeder::class,
            PostSeeder::class,
        ]);

        $this->command->info('Creating AI usage records (this will take a few minutes)...');
        $this->call(AiUsageSeeder::class, false, [
            'minRecordsPerUser' => 3,
            'maxRecordsPerUser' => 8,
        ]);

        $this->command->info('Creating subscriptions...');
        $this->call(SubscriptionSeeder::class, false, [
            'percentageOfUsers' => 0.1,
        ]);

        $this->command->info('Creating orders...');
        $this->call(OrderSeeder::class, false, [
            'percentageOfUsers' => 0.3,
            'minOrders' => 0,
            'maxOrders' => 2,
        ]);

        $this->command->info('Creating transactions (this will take a few minutes)...');
        $this->call([
            TransactionSeeder::class,
        ]);

        $duration = now()->diffForHumans($startTime, true);

        $this->command->info("✅ HEAVY seeding completed in {$duration}!");
        $this->command->warn('Database is now populated with ~10,000 users and extensive data.');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Seed the database with demo-quality data.
     *
     * Includes:
     * - 1 admin user
     * - 500 regular users
     * - All products and plans from CSV
     * - 2 tags with translations
     * - All blog posts from CSV
     * - Good AI usage (10-30 per user)
     * - Active subscriptions (~35% of users)
     * - Multiple orders (~25% of users, 1-5 orders each)
     * - Corresponding transactions
     *
     * Perfect for demonstrations and showcasing features.
     */
    public function run(): void
    {
        $this->command->info('🎨 Starting DEMO seeding...');

        $this->call([
            RoleSeeder::class,
        ]);

        $this->command->info('Creating users...');
        $this->call(UserSeeder::class, false, [
            'userCount' => 500,
            'createAdmin' => true,
        ]);

        $this->call([
            ProductSeeder::class,
            PlanSeeder::class,
            TagSeeder::class,
            PostSeeder::class,
        ]);

        $this->command->info('Creating AI usage records...');
        $this->call(AiUsageSeeder::class, false, [
            'minRecordsPerUser' => 10,
            'maxRecordsPerUser' => 30,
        ]);

        $this->command->info('Creating subscriptions...');
        $this->call(SubscriptionSeeder::class, false, [
            'percentageOfUsers' => 0.35,
        ]);

        $this->command->info('Creating orders...');
        $this->call(OrderSeeder::class, false, [
            'percentageOfUsers' => 0.25,
            'minOrders' => 1,
            'maxOrders' => 5,
        ]);

        $this->call([
            TransactionSeeder::class,
        ]);

        $this->command->info('✅ DEMO seeding completed!');
    }
}

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
     * - All products and plans from CSV
     * - 2 tags with translations
     * - All blog posts from CSV
     * - Minimal AI usage (2-5 per user)
     * - Few subscriptions (~20% of users)
     * - Few orders (~15% of users, 1-2 orders each)
     * - Corresponding transactions
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

        $this->call([
            ProductSeeder::class,
            // PlanSeeder::class,
            TagSeeder::class,
            PostSeeder::class,
        ]);

        $this->command->info('Creating AI usage records...');
        $this->call(AiUsageSeeder::class, false, [
            'minRecordsPerUser' => 2,
            'maxRecordsPerUser' => 5,
        ]);

        // $this->command->info('Creating subscriptions...');
        // $this->call(SubscriptionSeeder::class, false, [
        //     'percentageOfUsers' => 0.2,
        // ]);

        // $this->command->info('Creating orders...');
        // $this->call(OrderSeeder::class, false, [
        //     'percentageOfUsers' => 0.15,
        //     'minOrders' => 1,
        //     'maxOrders' => 2,
        // ]);

        // $this->call([
        //     TransactionSeeder::class,
        // ]);

        $this->command->info('✅ MINIMAL seeding completed!');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = public_path('plans.csv');

        if (! File::exists($csvFile)) {
            $this->command->warn('Plans CSV file not found at: '.$csvFile);

            return;
        }

        $file = fopen($csvFile, 'r');
        $headers = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            $data = array_combine($headers, $row);

            Plan::create([
                'name' => $data['name'],
                'lemon_squeezy_variant_id' => '1133364',
                'description' => $data['description'],
                'price' => (int) $data['price'],
                'currency' => $data['currency'],
                'billing_period' => $data['billing_period'],
                'status' => $data['status'],
                'trial_period' => $data['trial_period'] !== 'NULL' ? $data['trial_period'] : null,
                'trial_interval' => $data['trial_interval'] !== 'NULL' ? $data['trial_interval'] : null,
                'is_featured' => (bool) $data['is_featured'],
                'features' => json_decode($data['features'], true),
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]);
        }

        fclose($file);

        $this->command->info('Plans seeded successfully from CSV.');
    }
}

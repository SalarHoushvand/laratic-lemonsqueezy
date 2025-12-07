<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = public_path('products.csv');

        if (! File::exists($csvFile)) {
            $this->command->warn('Products CSV file not found at: '.$csvFile);

            return;
        }

        $file = fopen($csvFile, 'r');
        $headers = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            $data = array_combine($headers, $row);

            Product::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => (int) $data['price'],
                'currency' => $data['currency'],
                'lemon_squeezy_variant_id' => '1132128',
                'img_url' => $data['img_url'],
                'status' => $data['status'],
                'features' => json_decode($data['features'], true),
                'delivery_method' => $data['delivery_method'] !== 'NULL' ? $data['delivery_method'] : null,
                'category' => $data['category'] !== 'NULL' ? $data['category'] : null,
                'is_featured' => (bool) $data['is_featured'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ]);
        }

        fclose($file);

        $this->command->info('Products seeded successfully from CSV.');
    }
}

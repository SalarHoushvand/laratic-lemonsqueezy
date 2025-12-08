<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Models\Product;
use Illuminate\Console\Command;

class PromoteProductsAndPlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:promote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List and promote products and plans';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        do {
            $this->displayProductsAndPlans();

            $this->newLine();
            $this->comment('Use p-[id] for products (e.g., p-1) or s-[id] for subscriptions (e.g., s-1)');
            $id = $this->ask('Enter the ID to promote (or press Enter to exit)');

            if (empty($id)) {
                $this->info('Exiting...');

                return self::SUCCESS;
            }

            $this->toggleFeatured($id);

            $this->newLine();
            $continue = $this->confirm('Do you want to promote another product or plan?', true);
        } while ($continue);

        $this->info('Done!');

        return self::SUCCESS;
    }

    /**
     * Display all products and plans in a table.
     */
    protected function displayProductsAndPlans(): void
    {
        $products = Product::orderBy('id')->get();
        $plans = Plan::orderBy('id')->get();

        $data = [];

        // Add products
        foreach ($products as $product) {
            $data[] = [
                'id' => 'p-'.$product->id,
                'name' => $product->name,
                'type' => 'One-time',
                'featured' => $product->is_featured ? 'Yes' : 'No',
            ];
        }

        // Add plans
        foreach ($plans as $plan) {
            $data[] = [
                'id' => 's-'.$plan->id,
                'name' => $plan->name,
                'type' => 'Subscription',
                'featured' => ($plan->is_featured ?? false) ? 'Yes' : 'No',
            ];
        }

        if (empty($data)) {
            $this->warn('No products or plans found in the database.');

            return;
        }

        $this->info('Products and Plans:');
        $this->table(
            ['ID', 'Name', 'Type', 'Featured'],
            $data
        );
    }

    /**
     * Toggle featured status for a product or plan.
     */
    protected function toggleFeatured(string $input): void
    {
        $input = trim($input);

        // Parse the input to determine type and ID
        if (preg_match('/^p-(\d+)$/i', $input, $matches)) {
            // Product: p-[id]
            $id = (int) $matches[1];
            $product = Product::find($id);

            if (! $product) {
                $this->error("No product found with ID: {$id}");

                return;
            }

            $product->update(['is_featured' => ! $product->is_featured]);
            $product->refresh();

            $status = $product->is_featured ? 'featured' : 'unfeatured';
            $this->info("Product '{$product->name}' (ID: p-{$product->id}) has been {$status}.");

            return;
        }

        if (preg_match('/^s-(\d+)$/i', $input, $matches)) {
            // Plan (Subscription): s-[id]
            $id = (int) $matches[1];
            $plan = Plan::find($id);

            if (! $plan) {
                $this->error("No plan found with ID: {$id}");

                return;
            }

            $currentStatus = (bool) ($plan->is_featured ?? false);
            $plan->update(['is_featured' => ! $currentStatus]);
            $plan->refresh();

            $status = ($plan->is_featured ?? false) ? 'featured' : 'unfeatured';
            $this->info("Plan '{$plan->name}' (ID: s-{$plan->id}) has been {$status}.");

            return;
        }

        $this->error("Invalid format. Use p-[id] for products (e.g., p-1) or s-[id] for subscriptions (e.g., s-1).");
    }
}


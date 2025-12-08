<?php

namespace App\Livewire\Admin;

use App\Models\Plan;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin')]
class PlansProducts extends Component
{
    /**
     * Component mount.
     *
     * Sort order is managed directly via the database and drag-and-drop.
     */
    public function mount(): void
    {
        //
    }

    /**
     * Handle sorting of plans from the wire:sort directive.
     *
     * @param  int|string  $item
     * @param  int|string  $position
     */
    public function sortPlan(int|string $item, int|string $position): void
    {
        $itemId = (int) $item;
        $targetPosition = (int) $position;

        $planIds = Plan::orderBy('sort_order')
            ->orderBy('id')
            ->pluck('id')
            ->all();

        // Remove the moved item from the current order
        $planIds = array_values(array_diff($planIds, [$itemId]));

        // Insert the item into its new position
        array_splice($planIds, $targetPosition, 0, [$itemId]);

        foreach ($planIds as $index => $id) {
            Plan::whereKey($id)->update(['sort_order' => $index]);
        }
    }

    /**
     * Handle sorting of products from the wire:sort directive.
     *
     * @param  int|string  $item
     * @param  int|string  $position
     */
    public function sortProduct(int|string $item, int|string $position): void
    {
        $itemId = (int) $item;
        $targetPosition = (int) $position;

        $productIds = Product::orderBy('sort_order')
            ->orderBy('id')
            ->pluck('id')
            ->all();

        // Remove the moved item from the current order
        $productIds = array_values(array_diff($productIds, [$itemId]));

        // Insert the item into its new position
        array_splice($productIds, $targetPosition, 0, [$itemId]);

        foreach ($productIds as $index => $id) {
            Product::whereKey($id)->update(['sort_order' => $index]);
        }
    }

    /**
     * Toggle the featured status for a plan.
     */
    public function togglePlanFeatured(int $planId): void
    {
        $plan = Plan::findOrFail($planId);

        $plan->update([
            'is_featured' => ! (bool) $plan->is_featured,
        ]);
    }

    /**
     * Toggle the featured status for a product.
     */
    public function toggleProductFeatured(int $productId): void
    {
        $product = Product::findOrFail($productId);

        $product->update([
            'is_featured' => ! (bool) $product->is_featured,
        ]);
    }

    /**
     * Render the plans and products management page.
     */
    public function render(): View
    {
        $plans = Plan::orderBy('sort_order')

            ->get();

        $products = Product::orderBy('sort_order')

            ->get();

        return view('livewire.admin.plans-products', [
            'plans' => $plans,
            'products' => $products,
        ]);
    }

    /**
     * Sync plans and products with Lemon Squeezy via the existing Artisan command.
     */
    public function syncLemonSqueezyProducts(): void
    {
        $exitCode = Artisan::call('lemonsqueezy:sync-products');

        if ($exitCode === Command::SUCCESS) {
            $this->dispatch(
                'notify',
                variant: 'success',
                title: __('Sync complete'),
                message: __('Lemon Squeezy products and plans have been synced successfully.')
            );
        } else {
            $output = Artisan::output();

            Log::error('Lemon Squeezy sync via admin UI failed', [
                'exit_code' => $exitCode,
                'output' => $output,
            ]);

            $this->dispatch(
                'notify',
                variant: 'danger',
                title: __('Sync failed'),
                message: __('Unable to sync products and plans from Lemon Squeezy. Please check your configuration and logs, then try again.')
            );
        }
    }

    /**
     * Ensure all plans have a sort_order value.
     */
    private function initializePlanSortOrder(): void
    {
        $maxOrder = (int) (Plan::max('sort_order') ?? -1);

        Plan::where('sort_order', 0)
            ->orderBy('id')
            ->get()
            ->each(function (Plan $plan) use (&$maxOrder): void {
                $maxOrder++;

                $plan->update([
                    'sort_order' => $maxOrder,
                ]);
            });
    }

    /**
     * Ensure all products have a sort_order value.
     */
    private function initializeProductSortOrder(): void
    {
        $maxOrder = (int) (Product::max('sort_order') ?? -1);

        Product::where('sort_order', 0)
            ->orderBy('id')
            ->get()
            ->each(function (Product $product) use (&$maxOrder): void {
                $maxOrder++;

                $product->update([
                    'sort_order' => $maxOrder,
                ]);
            });
    }
}

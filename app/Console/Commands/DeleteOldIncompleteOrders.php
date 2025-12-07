<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DeleteOldIncompleteOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:delete-old-incomplete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all incomplete orders older than 24 hours';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $cutoffTime = Carbon::now()->subHours(24);

        $deletedCount = Order::where('status', 'incomplete')
            ->where('created_at', '<', $cutoffTime)
            ->delete();

        if ($deletedCount > 0) {
            $this->info("Successfully deleted {$deletedCount} incomplete order(s) older than 24 hours.");
        } else {
            $this->info('No incomplete orders older than 24 hours found.');
        }

        return 0;
    }
}

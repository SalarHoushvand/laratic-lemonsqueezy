<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lemon_squeezy_subscription_invoices', function (Blueprint $table) {
            $table->id();
            $table->morphs('billable');
            $table->string('lemon_squeezy_id')->unique();
            $table->string('subscription_id');
            $table->string('customer_id');
            $table->string('currency');
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('discount_total');
            $table->unsignedInteger('tax');
            $table->unsignedInteger('total');
            $table->string('status');
            $table->text('invoice_url')->nullable();
            $table->boolean('refunded')->default(false);
            $table->dateTime('refunded_at')->nullable();
            $table->string('billing_reason');
            $table->string('card_brand')->nullable();
            $table->string('card_last_four', 4)->nullable();
            $table->dateTime('invoiced_at');
            $table->timestamps();

            // Note: morphs('billable') already creates an index on ['billable_type', 'billable_id']
            $table->index('subscription_id');
            $table->index('customer_id');
            $table->index('status');
            $table->index('invoiced_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lemon_squeezy_subscription_invoices');
    }
};

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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lemon_squeezy_variant_id')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('price');
            $table->string('currency')->default('USD');
            $table->string('billing_period')->default('monthly');
            $table->string('status')->default('active');
            $table->string('trial_period')->nullable();
            $table->string('trial_interval')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->json('features')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

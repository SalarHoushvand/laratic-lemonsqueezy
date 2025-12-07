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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->unsignedInteger('price');
            $table->string('currency');
            $table->string('category')->nullable();
            $table->string('lemon_squeezy_variant_id');
            $table->string('img_url')->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->json('features')->nullable();
            $table->string('delivery_method')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

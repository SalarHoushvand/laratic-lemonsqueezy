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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number');
            $table->text('title');
            $table->text('description')->nullable();
            $table->text('slug')->unique();
            $table->text('image_url')->nullable();
            $table->string('author')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('is_promoted')->default(false);
            $table->boolean('is_active')->default(false);
            $table->string('language')->default('en');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

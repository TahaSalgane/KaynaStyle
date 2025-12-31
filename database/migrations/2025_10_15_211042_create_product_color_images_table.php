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
        Schema::create('product_color_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('color_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->boolean('is_main')->default(false); // Main image for this color
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            // Ensure unique main image per product-color combination
            $table->unique(['product_id', 'color_id', 'is_main'], 'unique_main_per_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_color_images');
    }
};

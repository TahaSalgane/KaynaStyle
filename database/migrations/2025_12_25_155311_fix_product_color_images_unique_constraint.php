<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable foreign key checks temporarily to drop the index
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Use raw SQL to drop the index
        DB::statement('ALTER TABLE product_color_images DROP INDEX unique_main_per_color');

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // For MySQL, we'll use a generated column workaround to ensure only one main image per product-color
        // This creates a column that is 1 for main images and NULL for non-main images
        // Then we create a unique index on (product_id, color_id, main_flag) which will
        // only enforce uniqueness when main_flag = 1 (since NULL values are ignored in unique indexes)
        DB::statement('ALTER TABLE product_color_images ADD COLUMN main_flag TINYINT(1) GENERATED ALWAYS AS (CASE WHEN is_main = 1 THEN 1 ELSE NULL END) STORED');

        Schema::table('product_color_images', function (Blueprint $table) {
            // Create unique index on the generated column to ensure only one main image per product-color
            // NULL values are ignored in unique indexes, so multiple non-main images are allowed
            $table->unique(['product_id', 'color_id', 'main_flag'], 'unique_main_per_color_fixed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_color_images', function (Blueprint $table) {
            $table->dropUnique('unique_main_per_color_fixed');
        });

        DB::statement('ALTER TABLE product_color_images DROP COLUMN main_flag');

        Schema::table('product_color_images', function (Blueprint $table) {
            // Restore the old constraint (even though it's problematic)
            $table->unique(['product_id', 'color_id', 'is_main'], 'unique_main_per_color');
        });
    }
};

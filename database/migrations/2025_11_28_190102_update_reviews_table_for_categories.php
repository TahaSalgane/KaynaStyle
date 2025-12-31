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
        Schema::table('reviews', function (Blueprint $table) {
            // Make product_id nullable and add category_id
            $table->foreignId('product_id')->nullable()->change();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade')->after('product_id');

            // Add new fields
            $table->string('review_title')->nullable()->after('customer_name');
            $table->string('media')->nullable()->after('review_text'); // Store path to uploaded media
            $table->string('email')->nullable()->after('media');
            $table->string('display_name')->nullable()->after('email'); // Public display name
            $table->enum('display_name_format', ['full', 'first_name_only', 'last_initial', 'all_initials', 'anonymous'])->default('first_name_only')->after('display_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'review_title', 'media', 'email', 'display_name', 'display_name_format']);
            $table->foreignId('product_id')->nullable(false)->change();
        });
    }
};

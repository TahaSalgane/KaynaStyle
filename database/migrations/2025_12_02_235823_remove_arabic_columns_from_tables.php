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
        // Remove Arabic columns from categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['name_ar', 'description_ar']);
        });

        // Remove Arabic columns from products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name_ar', 'description_ar']);
        });

        // Remove Arabic column from sizes table
        Schema::table('sizes', function (Blueprint $table) {
            $table->dropColumn('name_ar');
        });

        // Remove Arabic column from colors table
        Schema::table('colors', function (Blueprint $table) {
            $table->dropColumn('name_ar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore Arabic columns to categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name_ar')->after('name_en');
            $table->text('description_ar')->nullable()->after('description_en');
        });

        // Restore Arabic columns to products table
        Schema::table('products', function (Blueprint $table) {
            $table->string('name_ar')->after('name_en');
            $table->text('description_ar')->nullable()->after('description_en');
        });

        // Restore Arabic column to sizes table
        Schema::table('sizes', function (Blueprint $table) {
            $table->string('name_ar')->after('name_en');
        });

        // Restore Arabic column to colors table
        Schema::table('colors', function (Blueprint $table) {
            $table->string('name_ar')->after('name_en');
        });
    }
};

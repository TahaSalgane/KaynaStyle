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
        Schema::table('hero_images', function (Blueprint $table) {
            $table->dropColumn(['title', 'subtitle', 'button_text', 'button_url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hero_images', function (Blueprint $table) {
            $table->string('title')->after('id');
            $table->string('subtitle')->nullable()->after('title');
            $table->string('button_text')->nullable()->after('subtitle');
            $table->string('button_url')->nullable()->after('button_text');
        });
    }
};

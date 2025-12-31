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
        Schema::create('countdown_timers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->datetime('end_date');
            $table->boolean('is_active')->default(true);
            $table->string('background_color', 50)->default('#DC2626'); // Red
            $table->string('text_color', 50)->default('#FFFFFF'); // White
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countdown_timers');
    }
};

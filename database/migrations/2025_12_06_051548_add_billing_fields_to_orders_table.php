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
        Schema::table('orders', function (Blueprint $table) {
            // Add new billing fields
            $table->string('billing_email')->nullable()->after('customer_name');
            $table->string('billing_first_name')->nullable()->after('billing_email');
            $table->string('billing_last_name')->nullable()->after('billing_first_name');
            $table->string('billing_company')->nullable()->after('billing_last_name');
            $table->string('billing_country', 2)->default('US')->after('billing_company');
            $table->string('billing_address_1')->nullable()->after('billing_country');
            $table->string('billing_address_2')->nullable()->after('billing_address_1');
            $table->string('billing_city')->nullable()->after('billing_address_2');
            $table->string('billing_state')->nullable()->after('billing_city');
            $table->string('billing_postcode')->nullable()->after('billing_state');
            $table->string('billing_phone')->nullable()->after('billing_postcode');

            // Keep old fields for backward compatibility but make them nullable
            $table->string('customer_name')->nullable()->change();
            $table->string('customer_phone')->nullable()->change();
            $table->text('customer_address')->nullable()->change();
            $table->string('customer_city')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'billing_email',
                'billing_first_name',
                'billing_last_name',
                'billing_company',
                'billing_country',
                'billing_address_1',
                'billing_address_2',
                'billing_city',
                'billing_state',
                'billing_postcode',
                'billing_phone'
            ]);
        });
    }
};

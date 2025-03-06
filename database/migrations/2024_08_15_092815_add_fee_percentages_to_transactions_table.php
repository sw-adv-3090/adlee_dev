<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('transaction_fee_percentage')->nullable();
            $table->string('service_fee_percentage')->nullable();
            $table->boolean('commission_paid')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumns([
                'transaction_fee_percentage',
                'service_fee_percentage',
                'commission_paid',
            ]);
        });
    }
};

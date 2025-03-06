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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('sender_id')->constrained("users");
            $table->foreignId('receiver_id')->constrained("users");
            $table->foreignId('sponsor_id')->constrained();
            $table->foreignId('coupon_id')->nullable()->constrained();
            $table->string('amount');
            $table->string('paid_amount');
            $table->string('receiver_amount');
            $table->string('transaction_fee');
            $table->string('service_fee');
            $table->string('payment_intent_id');
            $table->string('transfer_id');
            $table->string('description');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

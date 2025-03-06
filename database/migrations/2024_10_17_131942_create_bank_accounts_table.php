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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('sponsor_id')->constrained();
            $table->string('payment_method_id');
            $table->string('setup_intent_id');
            $table->string('last4');
            $table->string('bank_name');
            $table->string('status')->default('pending');
            $table->timestamp('verified_at')->nullable();
            $table->string('failure_reason')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};

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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('name');
            $table->integer('price');
            $table->integer('ach_transaction_fee');
            $table->integer('credit_card_transaction_fee');
            $table->integer('transaction_service_fee');
            $table->integer('booklet_fee');
            $table->integer('booklet_pages');
            $table->integer('free_booklets');
            $table->string('stripe_product_id')->nullable();
            $table->string('stripe_price_id')->nullable();
            $table->json('specifications');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

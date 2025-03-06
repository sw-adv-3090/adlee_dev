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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('sponsor_id')->constrained();
            $table->foreignId('template_id')->constrained();
            $table->string('title');
            $table->string('language');
            $table->string('number')->unique();
            $table->integer('amount');
            $table->integer('payout_deadline');
            $table->string('shorten_url_activate')->nullable();
            $table->string('shorten_url_redeem')->nullable();
            $table->date('payout_on')->nullable()->comment('The date at which the payout will be initiated.');
            $table->dateTime('activated_at')->nullable();
            $table->dateTime('redeemed_at')->nullable();
            $table->dateTime('payout_at')->nullable()->comment('The time at which the payout initiated.');
            $table->string('redeemed_by')->nullable()->comment('Email of redeemed BBO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};

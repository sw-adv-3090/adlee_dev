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
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('company_name');
            $table->string('company_phone');
            $table->string('company_logo');
            $table->string('ein_number');
            $table->boolean('ein_number_verified')->default(false);
            // $table->boolean('ein_number_verified_at')->nullable();
            $table->integer('ein_number_verify_tries');
            $table->timestamp('ein_number_verify_last_try');
            $table->boolean('paying_commission');
            $table->integer('default_coupon_payout');
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_postal_code')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_country')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};

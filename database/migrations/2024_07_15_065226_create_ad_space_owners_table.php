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
        Schema::create('ad_space_owners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('company_name');
            $table->string('company_phone');
            $table->string('company_logo');
            $table->string('ein_number')->nullable();
            $table->timestamp('ein_number_verified_at')->nullable();
            $table->integer('ein_number_verify_tries')->nullable();
            $table->timestamp('ein_number_verify_last_try')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_space_owners');
    }
};

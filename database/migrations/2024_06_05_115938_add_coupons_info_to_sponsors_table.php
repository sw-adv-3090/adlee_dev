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
        Schema::table('sponsors', function (Blueprint $table) {
            $table->boolean('is_commemoration')->default(false);
            $table->string('code')->nullable();
            $table->string('last_coupon')->default('0000');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn('is_commemoration');
            $table->dropColumn('code');
            $table->dropColumn('last_coupon');
        });
    }
};

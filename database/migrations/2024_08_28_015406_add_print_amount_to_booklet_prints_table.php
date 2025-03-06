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
        Schema::table('booklet_prints', function (Blueprint $table) {
            $table->integer('amount_paid')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booklet_prints', function (Blueprint $table) {
            $table->dropColumn('amount_paid');
        });
    }
};

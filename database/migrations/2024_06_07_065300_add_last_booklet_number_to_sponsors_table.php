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
            $table->string('name_code')->after('is_commemoration');
            $table->string('last_booklet')->default('0000');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn('name_code');
            $table->dropColumn('last_booklet');
        });
    }
};

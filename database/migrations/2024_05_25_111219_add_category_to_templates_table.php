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
        Schema::table('templates', function (Blueprint $table) {
            $table->after('view', function (Blueprint $table) {
                $table->string('language');
                $table->foreignId('category_id')->nullable()->constrained();
                $table->foreignId('sub_category_id')->nullable()->constrained();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn(['language', 'category_id', 'sub_category_id']);
        });
    }
};

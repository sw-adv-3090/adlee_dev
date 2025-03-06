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
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('ach_transaction_fee')->nullable()->change();
            $table->integer('credit_card_transaction_fee')->nullable()->change();
            $table->integer('transaction_service_fee')->nullable()->change();
            $table->integer('booklet_fee')->nullable()->change();
            $table->integer('booklet_pages')->nullable()->change();
            $table->integer('free_booklets')->nullable()->change();
            $table->integer('template_limit')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('ach_transaction_fee')->change();
            $table->integer('credit_card_transaction_fee')->change();
            $table->integer('transaction_service_fee')->change();
            $table->integer('booklet_fee')->change();
            $table->integer('booklet_pages')->change();
            $table->integer('free_booklets')->change();
            $table->integer('template_limit')->change();
        });
    }
};

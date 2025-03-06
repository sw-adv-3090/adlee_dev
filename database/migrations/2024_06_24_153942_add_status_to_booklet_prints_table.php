<?php

use App\Enums\BookletPrintStatus;
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
            $table->string('status')->default(BookletPrintStatus::SEND->value)->after('booklet_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booklet_prints', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('designer_templates', function (Blueprint $table) {
            $table->float('additional_image_width');
            $table->float('additional_image_height');
            $table->smallInteger('approve')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designer_templates', function (Blueprint $table) {
            $table->dropColumn('additional_image_width');
            $table->dropColumn('additional_image_height');
            $table->dropColumn('approve');

        });
    }
    
};

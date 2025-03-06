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
        Schema::create('designer_templates', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('type');
            $table->string('file');
            $table->string('preview');
            $table->string('language');
            $table->float('height');
            $table->float('width');
            $table->text('meta_data');
            $table->foreignId('category_id')->nullable()->index();
            $table->foreignId('sub_category_id')->nullable();
            $table->foreignId('created_by')->index();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designer_templates');
    }
};

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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('type');
            $table->string('title');
            $table->text('styling')->nullable();
            $table->text('content')->nullable();
            $table->string('preview');
            $table->boolean('active')->default(true);
            $table->date('publish_at')->nullable();
            $table->string('view');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};

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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('sponsor_id')->constrained();
            $table->foreignId('coupon_id')->constrained();
            // $table->foreignId('template_id')->nullable()->constrained();
            $table->foreignId('template_id')->nullable()->constrained('designer_templates');
            $table->foreignId('assign_to')->nullable()->constrained('users', 'id');
            $table->boolean('is_commemoration');
            $table->string('language')->nullable();
            $table->string('purpose')->nullable();
            $table->string('english_name')->nullable();
            $table->string('hebrew_name')->nullable();
            $table->string('status')->default('activated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('booklet_print_id')->constrained();
            $table->string('label_id');
            $table->string('shipment_id');
            $table->string('tracking_number');
            $table->string('status');
            $table->string('tracking_status');
            $table->string('amount');
            $table->string('carrier_id');
            $table->string('service_code');
            $table->string('tracking_url')->nullable();
            $table->string('download_pdf')->nullable();
            $table->string('download_png')->nullable();
            $table->string('download_zpl')->nullable();
            $table->timestamp('ship_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};

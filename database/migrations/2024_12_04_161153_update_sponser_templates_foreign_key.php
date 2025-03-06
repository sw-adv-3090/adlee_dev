<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up()
    {
        Schema::table('sponsor_templates', function (Blueprint $table) {
            $table->dropForeign('sponsor_templates_template_id_foreign');
            $table->foreign('template_id')->references('id')->on('designer_templates');
        });
    }

    public function down()
    {
        Schema::table('sponsor_templates', function (Blueprint $table) {
            $table->dropForeign('sponsor_templates_template_id_foreign');
            $table->foreign('template_id')->references('id')->on('templates');
        });
    }
};
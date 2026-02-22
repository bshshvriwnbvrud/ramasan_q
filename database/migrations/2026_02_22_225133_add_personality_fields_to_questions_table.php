<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('questions', function (Blueprint $table) {
        $table->string('personality_name')->nullable();
        $table->text('personality_description')->nullable();
        $table->string('personality_image')->nullable();
    });
}

public function down()
{
    Schema::table('questions', function (Blueprint $table) {
        $table->dropColumn([
            'personality_name',
            'personality_description',
            'personality_image'
        ]);
    });
}
};

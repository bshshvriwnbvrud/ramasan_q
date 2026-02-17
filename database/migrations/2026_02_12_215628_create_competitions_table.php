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
    Schema::create('competitions', function (Blueprint $table) {
        $table->id();
        $table->unsignedTinyInteger('day_number')->unique();
        $table->string('title')->nullable();
        $table->dateTime('starts_at');
        $table->dateTime('ends_at');
        $table->boolean('is_published')->default(false);

        $table->enum('timer_mode', ['uniform', 'per_question'])->default('uniform');
        $table->unsignedInteger('uniform_time_sec')->nullable();

        $table->boolean('results_published')->default(false);

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};

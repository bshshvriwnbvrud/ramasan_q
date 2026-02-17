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
        Schema::create('attempt_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('attempts')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();

            $table->unsignedInteger('question_index');
            $table->enum('selected_choice', ['A','B','C','D'])->nullable();
            $table->boolean('is_correct')->default(false);
            $table->boolean('was_late')->default(false);
            $table->dateTime('answered_at')->nullable();

            $table->unique(['attempt_id', 'question_index']);
            $table->index(['attempt_id', 'question_id']);
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attempt_answers');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('attempts', function (Blueprint $table) {

            $table->id();

            // العلاقات
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('competition_id')
                  ->constrained()
                  ->onDelete('cascade');

            // حالة المحاولة
            $table->enum('status', ['in_progress', 'submitted', 'timeout'])
                  ->default('in_progress');

            // التوقيت
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('current_question_started_at')->nullable();

            // تتبع التقدم
            $table->integer('current_index')->default(0);

            // النتائج
            $table->integer('score')->default(0);
            $table->integer('correct_count')->default(0);
            $table->integer('wrong_count')->default(0);
            $table->integer('blank_count')->default(0);

            // تتبع الأمان
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();

            // منع أكثر من محاولة لنفس المستخدم في نفس المسابقة
            $table->unique(['user_id', 'competition_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attempts');
    }
};

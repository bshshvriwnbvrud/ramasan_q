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
    // Schema::table('attempts', function (Blueprint $table) {
    //     $table->unsignedInteger('current_index')->default(1)->after('competition_id');
    //     $table->dateTime('current_question_started_at')->nullable()->after('started_at');
    // });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attempts', function (Blueprint $table) {
            //
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('competitions', function (Blueprint $table) {
            $table->string('personality_name')->nullable()->after('results_published');
            $table->text('personality_description')->nullable()->after('personality_name');
            $table->string('personality_image')->nullable()->after('personality_description');
            $table->boolean('personality_enabled')->default(false)->after('personality_image');
        });
    }

    public function down(): void
    {
        Schema::table('competitions', function (Blueprint $table) {
            $table->dropColumn(['personality_name', 'personality_description', 'personality_image', 'personality_enabled']);
        });
    }
};
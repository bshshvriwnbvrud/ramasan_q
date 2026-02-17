<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('competitions', function (Blueprint $table) {
            if (!Schema::hasColumn('competitions', 'personality_name')) {
                $table->string('personality_name')->nullable()->after('results_published');
            }
            if (!Schema::hasColumn('competitions', 'personality_description')) {
                $table->text('personality_description')->nullable()->after('personality_name');
            }
            if (!Schema::hasColumn('competitions', 'personality_image')) {
                $table->string('personality_image')->nullable()->after('personality_description');
            }
            if (!Schema::hasColumn('competitions', 'personality_enabled')) {
                $table->boolean('personality_enabled')->default(false)->after('personality_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('competitions', function (Blueprint $table) {
            $columns = ['personality_name', 'personality_description', 'personality_image', 'personality_enabled'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('competitions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
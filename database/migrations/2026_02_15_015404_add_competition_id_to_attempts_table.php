<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('attempts', function (Blueprint $table) {
            if (!Schema::hasColumn('attempts', 'competition_id')) {
                $table->foreignId('competition_id')->after('user_id')->constrained()->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('attempts', function (Blueprint $table) {
            if (Schema::hasColumn('attempts', 'competition_id')) {
                $table->dropConstrainedForeignId('competition_id');
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // تحديث تعريف ENUM ليشمل القيم الجديدة
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'supervisor', 'editor', 'student') NOT NULL DEFAULT 'student'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // العودة إلى الحالة السابقة (إذا أردنا التراجع)
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'student') NOT NULL DEFAULT 'student'");
    }
};
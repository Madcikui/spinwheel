<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite/MySQL/PostgreSQL: NULL nilai dianggap distinct dalam UNIQUE,
        // jadi banyak baris bonus-code (student_id NULL) masih dibenarkan.
        Schema::table('spin_logs', function (Blueprint $table) {
            $table->unique('student_id', 'spin_logs_student_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('spin_logs', function (Blueprint $table) {
            $table->dropUnique('spin_logs_student_id_unique');
        });
    }
};

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
        Schema::table('students', function (Blueprint $table) {
            // Rename existing fields
            $table->renameColumn('nama_ibu_bapa', 'nama_ayah');
            $table->renameColumn('ic_ibu_bapa', 'ic_ayah');
        });

        Schema::table('students', function (Blueprint $table) {
            // Add ibu fields
            $table->string('nama_ibu')->nullable()->after('ic_ayah');
            $table->string('ic_ibu', 20)->nullable()->after('nama_ibu');

            $table->index('ic_ibu');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['ic_ibu']);
            $table->dropColumn(['nama_ibu', 'ic_ibu']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->renameColumn('nama_ayah', 'nama_ibu_bapa');
            $table->renameColumn('ic_ayah', 'ic_ibu_bapa');
        });
    }
};

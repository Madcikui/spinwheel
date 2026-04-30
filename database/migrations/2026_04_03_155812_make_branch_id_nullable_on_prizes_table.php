<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('prizes', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->change();
        });

        // Set all existing prizes to shared (null branch)
        DB::table('prizes')->update(['branch_id' => null]);
    }

    public function down(): void
    {
        Schema::table('prizes', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable(false)->change();
        });
    }
};

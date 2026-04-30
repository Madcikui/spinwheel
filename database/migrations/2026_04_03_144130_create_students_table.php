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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->string('nama_pelajar');
            $table->string('ic_pelajar', 20)->nullable();
            $table->string('nama_ibu_bapa');
            $table->string('ic_ibu_bapa', 20);
            $table->string('no_telefon', 20)->nullable();
            $table->string('kelas')->nullable();
            $table->timestamps();

            $table->index('ic_pelajar');
            $table->index('ic_ibu_bapa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

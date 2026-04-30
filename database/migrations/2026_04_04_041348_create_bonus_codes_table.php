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
        Schema::create('bonus_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->enum('status', ['unused', 'used'])->default('unused');
            $table->string('used_by_name')->nullable();
            $table->foreignId('spin_log_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonus_codes');
    }
};

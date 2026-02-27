<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('quiz_results', 'quiz_attempts');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('quiz_attempts', 'quiz_results');
    }
};

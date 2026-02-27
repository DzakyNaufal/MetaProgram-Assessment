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
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->onDelete('cascade'); // Remove constrained() to avoid foreign key constraint during creation
            $table->foreignId('quiz_attempt_id')->onDelete('cascade'); // Remove constrained() to avoid foreign key constraint during creation
            $table->foreignId('question_id')->onDelete('cascade'); // Remove constrained() to avoid foreign key constraint during creation
            $table->integer('answer'); // Jawaban dari pertanyaan (1-5 untuk skala Likert)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_results');
    }
};

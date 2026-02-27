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
        // Drop quiz_answers table (unused - no model exists)
        Schema::dropIfExists('quiz_answers');

        // Remove talent_type column from question_options table (legacy from RES/CON/EXP/ANA system)
        if (Schema::hasColumn('question_options', 'talent_type')) {
            Schema::table('question_options', function (Blueprint $table) {
                $table->dropColumn('talent_type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate quiz_answers table
        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_attempt_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->foreignId('option_id')->nullable();
            $table->timestamps();
        });

        // Restore talent_type column to question_options table
        Schema::table('question_options', function (Blueprint $table) {
            $table->string('talent_type', 10)->nullable()->after('option_text');
        });
    }
};

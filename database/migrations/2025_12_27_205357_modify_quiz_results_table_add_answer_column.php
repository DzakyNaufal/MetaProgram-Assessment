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
        Schema::table('quiz_results', function (Blueprint $table) {
            // Add user_id column if not exists
            if (!Schema::hasColumn('quiz_results', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            }

            // Add answer column if not exists (for Likert scale 1-5)
            if (!Schema::hasColumn('quiz_results', 'answer')) {
                $table->integer('answer')->default(3)->after('option_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_results', function (Blueprint $table) {
            if (Schema::hasColumn('quiz_results', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('quiz_results', 'answer')) {
                $table->dropColumn('answer');
            }
        });
    }
};

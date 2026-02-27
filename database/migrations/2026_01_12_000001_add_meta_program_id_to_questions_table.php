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
        Schema::table('questions', function (Blueprint $table) {
            // Add meta_program_id column
            $table->unsignedBigInteger('meta_program_id')->nullable()->after('course_id');

            // Add foreign key constraint
            $table->foreign('meta_program_id')
                  ->references('id')
                  ->on('meta_programs')
                  ->onDelete('set null');

            // Add index for better query performance
            $table->index('meta_program_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['meta_program_id']);

            // Drop index
            $table->dropIndex(['meta_program_id']);

            // Drop column
            $table->dropColumn('meta_program_id');
        });
    }
};

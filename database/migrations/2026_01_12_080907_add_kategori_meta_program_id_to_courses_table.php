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
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('kategori_meta_program_id')->nullable()->after('type');
            $table->foreign('kategori_meta_program_id')->references('id')->on('kategori_meta_programs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['kategori_meta_program_id']);
            $table->dropColumn('kategori_meta_program_id');
        });
    }
};

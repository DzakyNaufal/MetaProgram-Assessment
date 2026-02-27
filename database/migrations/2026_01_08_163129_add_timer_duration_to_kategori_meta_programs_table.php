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
        Schema::table('kategori_meta_programs', function (Blueprint $table) {
            $table->integer('timer_duration')->default(1800)->after('is_active')->comment('Timer duration in seconds (default: 30 minutes = 1800 seconds)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori_meta_programs', function (Blueprint $table) {
            $table->dropColumn('timer_duration');
        });
    }
};

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
            // Add has_whatsapp_consultation column
            if (!Schema::hasColumn('courses', 'has_whatsapp_consultation')) {
                $table->boolean('has_whatsapp_consultation')->default(false)->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'has_whatsapp_consultation')) {
                $table->dropColumn('has_whatsapp_consultation');
            }
        });
    }
};

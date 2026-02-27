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
        Schema::table('purchases', function (Blueprint $table) {
            if (!Schema::hasColumn('purchases', 'course_id')) {
                $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('purchases', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('proof_image');
            }
            if (!Schema::hasColumn('purchases', 'quiz_attempt_id')) {
                $table->foreignId('quiz_attempt_id')->nullable()->after('whatsapp_number')->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('purchases', 'admin_id')) {
                $table->foreignId('admin_id')->nullable()->after('quiz_attempt_id')->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('purchases', 'confirmed_at')) {
                $table->timestamp('confirmed_at')->nullable()->after('updated_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            if (Schema::hasColumn('purchases', 'quiz_attempt_id')) {
                $table->dropForeign(['quiz_attempt_id']);
            }
            if (Schema::hasColumn('purchases', 'admin_id')) {
                $table->dropForeign(['admin_id']);
            }
            if (Schema::hasColumn('purchases', 'course_id')) {
                $table->dropForeign(['course_id']);
            }
            $columnsToDrop = array_filter(['course_id', 'payment_method', 'quiz_attempt_id', 'admin_id', 'confirmed_at'], function($col) {
                return Schema::hasColumn('purchases', $col);
            });
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};

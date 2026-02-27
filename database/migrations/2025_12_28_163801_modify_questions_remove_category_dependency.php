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
            // Drop foreign key constraint for category_id
            $table->dropForeign(['category_id']);
            // Make category_id nullable
            $table->unsignedBigInteger('category_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // Add back foreign key constraint
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            // Make category_id not nullable
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
        });
    }
};

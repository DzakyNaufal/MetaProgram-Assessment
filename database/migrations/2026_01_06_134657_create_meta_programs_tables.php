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
        // Tabel Kategori Meta Program
        Schema::create('kategori_meta_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel Meta Program
        Schema::create('meta_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_meta_program_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name'); // Contoh: "MP 1 - Chunk Size"
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('scoring_type')->default('inverse'); // inverse, multi
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel Sub Meta Program
        Schema::create('sub_meta_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meta_program_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Contoh: "Global", "Specific"
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['meta_program_id', 'slug']);
        });

        // Tabel Pertanyaan Meta Program
        Schema::create('pertanyaan_meta_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meta_program_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_meta_program_id')->nullable()->constrained()->onDelete('set null');
            $table->text('pertanyaan');
            $table->integer('skala_sangat_setuju')->default(6); // 6
            $table->integer('skala_setuju')->default(5); // 5
            $table->integer('skala_agak_setuju')->default(4); // 4
            $table->integer('skala_agak_tidak_setuju')->default(3); // 3
            $table->integer('skala_tidak_setuju')->default(2); // 2
            $table->integer('skala_sangat_tidak_setuju')->default(1); // 1
            $table->text('keterangan')->nullable(); // Penjelasan untuk menentukan dominan
            $table->boolean('is_negatif')->default(false); // Jika true, skala dibalik
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_meta_programs');
        Schema::dropIfExists('sub_meta_programs');
        Schema::dropIfExists('meta_programs');
        Schema::dropIfExists('kategori_meta_programs');
    }
};

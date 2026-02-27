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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tier_id')->onDelete('cascade'); // Remove constrained() to avoid foreign key constraint during creation
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'rejected', 'expired'])->default('pending');
            $table->string('proof_image')->nullable(); // path to uploaded proof image
            $table->string('sender_name')->nullable();
            $table->string('sender_bank')->nullable();
            $table->date('transfer_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('whatsapp_number')->nullable(); // for premium tier
            $table->timestamp('expired_at')->nullable(); // auto-expire after 48 hours
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};

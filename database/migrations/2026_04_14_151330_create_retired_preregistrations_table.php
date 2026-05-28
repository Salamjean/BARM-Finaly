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
        Schema::create('retired_preregistrations', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('mecano', 20); // Limiter la taille du mecano
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('message')->nullable();
            $table->boolean('verified')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->foreignId('retired_id')->nullable()->constrained('retireds')->onDelete('set null');
            $table->timestamp('processed_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Index séparés pour éviter le problème de taille
            $table->index('mecano');
            $table->index(['status', 'verified']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retired_preregistrations');
    }
};

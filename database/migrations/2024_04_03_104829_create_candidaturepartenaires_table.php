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
        Schema::create('candidaturepartenaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidature_id')->nullable()->constrained('candidatures');
            $table->foreignId('partenaire_id')->nullable()->constrained('partenaires');
            $table->enum('status', ['accepted', 'refused'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidaturepatenaires');
    }
};

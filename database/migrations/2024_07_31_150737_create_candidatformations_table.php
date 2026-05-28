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
        Schema::create('candidatformations', function (Blueprint $table) {
            $table->id();
            $table->integer('candidature_id')->nullable();
            $table->integer('formation_id')->nullable();
            $table->boolean('presence')->default('0');
            $table->longText('commentaire')->nullable();
            $table->string('attestation')->nullable();
            $table->integer('autor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatformations');
    }
};

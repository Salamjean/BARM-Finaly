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
        Schema::create('offreemplois', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            $table->longText('description')->nullable();
            $table->string('localisation')->nullable();
            $table->date('datefin')->nullable();
            $table->string('autor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offreemplois');
    }
};

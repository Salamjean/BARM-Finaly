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
        Schema::create('inscriptionconcours', function (Blueprint $table) {
            $table->id();
            $table->string('candidature_id')->nullable();
            $table->date('date')->nullable();
            $table->string('recu')->nullable();
            $table->string('intitule_concours')->nullable();
            $table->string('type_concours')->nullable();
            $table->boolean('status')->nullable();
            $table->string('autor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscriptionconcours');
    }
};

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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('localisation')->nullable();
            $table->string('specialisation')->nullable();
            $table->string('num_decharge')->nullable();
            $table->string('nom_point_focal')->nullable();
            $table->string('num_point_focal')->nullable();
            $table->string('email_point_focal')->nullable();
            $table->string('type')->nullable();
            $table->integer('autor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};

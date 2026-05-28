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
        Schema::create('bilancompetences', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('rapport')->nullable();
            $table->longText('comment')->nullable();
            $table->string('presence')->nullable();
            $table->integer('candidature_id')->nullable();
            $table->integer('autor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bilancompetences');
    }
};

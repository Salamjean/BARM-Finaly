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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('objectifs');
            $table->text('cible');
            $table->text('canal');
            $table->string('periode');
            $table->string('budget');
            $table->string('source')->nullable();
            $table->text('observations');
            $table->enum('status', ['En attente','En cours', 'Terminée'])->default('En Attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};

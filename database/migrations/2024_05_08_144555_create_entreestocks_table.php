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
        Schema::create('entreestocks', function (Blueprint $table) {
            $table->id();
            $table->integer('consommable_id')->nullable();
            $table->string('qte_entree')->nullable();
            $table->string('date_entree')->nullable();
            $table->string('fournisseur')->nullable();
            $table->string('temoin1')->nullable();
            $table->string('temoin2')->nullable();
            $table->string('temoin3')->nullable();
            $table->integer('crator_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreestocks');
    }
};

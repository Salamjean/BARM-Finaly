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
        Schema::create('consommables', function (Blueprint $table) {
            $table->id();
            $table->string('designation')->nullable();
            $table->longText('description')->nullable();
            $table->enum('is_visible', ['0','1'])->nullable();
            $table->string('qte_disponible')->nullable();
            $table->string('stock_min')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consommables');
    }
};

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
        Schema::create('pointings', function (Blueprint $table) {
            $table->id();
            $table->integer('personal_id');
            $table->date('date');
            $table->time('start_from')->nullable();
            $table->time('end_to')->nullable();
            $table->enum('status', ['in_progress', 'finished'])->default('in_progress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pointings');
    }
};

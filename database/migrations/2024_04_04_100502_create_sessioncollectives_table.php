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
        Schema::create('sessioncollectives', function (Blueprint $table) {
            $table->id();
            $table->integer('cohort_id')->nullable();
            $table->string('lieu')->nullable();
            $table->date('date')->nullable();
            $table->string('heure')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessioncollectives');
    }
};

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
        Schema::create('profilages', function (Blueprint $table) {
            $table->id();
            $table->integer('cohort_id')->nullable();
            $table->integer('sessioncollective_id')->nullable();
            $table->integer('partenaire_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('end')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profilages');
    }
};

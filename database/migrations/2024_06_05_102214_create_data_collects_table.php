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
        Schema::create('data_collects', function (Blueprint $table) {
            $table->id();
            $table->integer('candidature_id');
            $table->string('beging_date');
            $table->string('end_date')->nullable();
            $table->json('documents')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_collects');
    }
};

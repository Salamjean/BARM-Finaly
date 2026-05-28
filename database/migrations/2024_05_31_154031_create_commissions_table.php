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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->date('date')->nullable();
            $table->integer('cohort_id')->nullable();
            $table->string('rapport')->nullable();
            $table->string('lieu')->nullable();
            $table->string('file_presence')->nullable();
            $table->string('file_presence_partner')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};

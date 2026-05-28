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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->integer('cohort_id');
            $table->integer('partner_technicial_id');
            $table->string('title');
            $table->string('file_presence')->nullable();
            
            $table->text('description')->nullable();
            $table->text('observation')->nullable();
            $table->date('beging_date');
            $table->date('end_date')->nullable();
            $table->enum('status',['pending', 'finished'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};

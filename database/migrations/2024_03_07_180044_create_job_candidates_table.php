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
        Schema::create('job_candidates', function (Blueprint $table) {
            $table->id();
            $table->integer('candidature_id');
            $table->string('periode');
            $table->string('organism');   
            $table->string('fonction');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_candidates');
    }
};

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
        Schema::create('child_candidates', function (Blueprint $table) {
            $table->id();
            $table->integer('candidature_id');
            $table->string('fullname');
            $table->string('birth_date')->nullable();
            $table->string('level')->nullable();
            $table->string('file')->nullable();
            $table->string('job')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_candidates');
    }
};

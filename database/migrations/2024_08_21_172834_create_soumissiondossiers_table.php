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
        Schema::create('soumissiondossiers', function (Blueprint $table) {
            $table->id();
            $table->string('candidature_id')->nullable();
            $table->string('intitule_concours1')->nullable();
            $table->string('type_concours1')->nullable();
            $table->date('date1')->nullable();
            $table->string('intitule_concours2')->nullable();
            $table->string('type_concours2')->nullable();
            $table->date('date2')->nullable();
            $table->string('autor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soumissiondossiers');
    }
};

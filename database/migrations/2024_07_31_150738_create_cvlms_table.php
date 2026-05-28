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
        Schema::create('cvlms', function (Blueprint $table) {
            $table->id();
            $table->integer('candidature_id')->nullable();
            $table->string('cv')->nullable();
            $table->string('lm')->nullable();
            $table->string('poste')->nullable();
            $table->enum('type', ["cv","lm","cvlm"])->nullable();
            $table->boolean('presence')->default('0');
            $table->date('date')->nullable();
            $table->longText('commentaire')->nullable();
            $table->integer('autor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cvlms');
    }
};

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
        Schema::create('candidature_sessioncollective', function (Blueprint $table) {
            $table->id();
            $table->integer('sessioncollective_id')->nullable();
            $table->integer('candidature_id')->nullable();
            $table->string('methode_prise_contact')->nullable();
            $table->longText('commentaire')->nullable();
            $table->boolean('presence')->default('0');
            $table->boolean('presence_status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidature_sessioncollective');
    }
};

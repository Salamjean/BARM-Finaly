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
        Schema::create('lettrerecommandations', function (Blueprint $table) {
            $table->id();
            $table->integer(column: 'candidature_id')->nullable();
            $table->date('date_demande')->nullable();
            $table->boolean('status')->nullable();
            $table->longText('commentaire')->nullable();
            $table->string('lettre')->nullable();
            $table->integer('autor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lettrerecommandations');
    }
};

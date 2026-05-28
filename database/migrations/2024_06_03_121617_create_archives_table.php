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
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->integer('dossier_id');
            $table->string('titre');
            $table->string('description');
            $table->string('image');
            $table->date('date_publication');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};

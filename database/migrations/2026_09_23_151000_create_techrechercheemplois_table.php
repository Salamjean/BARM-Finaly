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
        Schema::create('techrechercheemplois', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidature_id')->index();
            $table->date('date')->nullable();
            $table->tinyInteger('presence')->default(1); // 1 = Présent / Réalisé, 0 = Absent, 2 = Abandon
            $table->longText('commentaire')->nullable();
            $table->unsignedBigInteger('autor_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('techrechercheemplois');
    }
};

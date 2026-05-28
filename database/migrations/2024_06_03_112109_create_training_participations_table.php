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
        Schema::create('training_participations', function (Blueprint $table) {
            $table->id();
            $table->integer('training_id');
            $table->integer('candidature_id');
            $table->boolean('participation')->default(true);
            $table->text('observation')->nullable();
            $table->enum('moment', ['pre', 'post']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_participations');
    }
};

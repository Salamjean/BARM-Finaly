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
        Schema::create('rdvpartners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partenaire_id')->nullable()->constrained('partenaires');
            $table->foreignId('candidature_id')->nullable()->constrained('candidatures');
            $table->boolean('presence')->default('0');
            $table->date('date')->nullable();
            $table->string('heure')->nullable();
            $table->string('lieu')->nullable();
            $table->longText('rapport')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rdvpartners');
    }
};

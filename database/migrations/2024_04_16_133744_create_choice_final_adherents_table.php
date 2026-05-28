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
        Schema::create('choice_final_adherents', function (Blueprint $table) {
            $table->id();
            $table->integer('candidature_id');
            $table->integer('partner_id')->nullable();

            $table->enum('choice_number', ['one', 'two', 'other']);

            $table->string('domaine')->nullable();
            $table->string('specialisation');
            $table->string('region_retraite')->nullable();
            $table->string('department')->nullable();
            $table->string('locality')->nullable();
            $table->string('adress_geo')->nullable();
            $table->string('formation')->nullable();
            $table->string('autres_form')->nullable();
            $table->date('profilage_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('choice_final_adherents');
    }
};

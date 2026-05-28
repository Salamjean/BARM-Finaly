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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('photo')->nullable();
            $table->enum('type', ['civil','militaire'])->nullable();
            $table->string('matricule_barm')->unique()->nullable();
            $table->string('ville_barm')->nullable();
            $table->string('matricule_fae')->unique()->nullable();
            $table->string('matricule')->unique()->nullable();
            $table->string('gender')->nullable();

            $table->string('grade')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('nbre_enfant')->nullable();
            $table->string('no_card')->nullable();
            $table->string('date_etabli')->nullable();
            $table->string('lieu_etabli')->nullable();
            $table->string('date_validate')->nullable();
            $table->string('no_cim')->nullable();
            $table->string('groupe_sanguin')->nullable();
            $table->string('lieu_residence')->nullable();
            $table->string('fonction')->nullable();
            $table->string('date_prise_service_barm')-> nullable();
            $table->string('lieu_service')->nullable();
            $table->string('diplome_militaire')->nullable();
            $table->string('diplome_civil_eleve')->nullable();
            $table->string('derniere_formation')->nullable();
            $table->string('lieu_formation')->nullable();
            $table->string('annee_de_formation')->nullable();
            $table->string('statut_personnel')->nullable();
            $table->string('nom_cas_urgence')->nullable();
            $table->string('telephone_cas_urgence')->nullable();
            $table->enum('status', ['0','1'])->default(1);

            $table->enum('death', ['0', '1'])->default(0);
            $table->date('death_date')->nullable();
            $table->string('death_no_act')->nullable();
            $table->string('death_city')->nullable();
            $table->string('death_justification')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnels');
    }
};

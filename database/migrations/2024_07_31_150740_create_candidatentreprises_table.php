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
        Schema::create('candidatentreprises', function (Blueprint $table) {
            $table->id();
            $table->integer('candidature_id')->nullable();
            $table->string('entreprise')->nullable();
            $table->date('date_mise_disposition')->nullable();
            $table->enum('statut', ["pending","accepted","refused","finished","on_hold"])->default('pending');
            $table->string('service')->nullable();
            $table->string('poste')->nullable();
            $table->string('lettre_recommandation')->nullable();
            $table->string('type_contrat')->nullable();
            $table->date('date_db')->nullable();
            $table->date('date_fin')->nullable();
            $table->string('contrat')->nullable();
            $table->string('localisation')->nullable();
            $table->longText('commentaire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatentreprises');
    }
};

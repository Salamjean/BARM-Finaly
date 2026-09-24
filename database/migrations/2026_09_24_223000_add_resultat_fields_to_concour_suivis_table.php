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
        Schema::table('concour_suivis', function (Blueprint $table) {
            $table->string('resultat_statut')->nullable()->after('choix_final_motif'); // 'admis', 'ajourne', null (en attente)
            $table->date('resultat_date')->nullable()->after('resultat_statut');
            $table->string('resultat_attestation')->nullable()->after('resultat_date');
            $table->string('resultat_affectation')->nullable()->after('resultat_attestation');
            $table->text('resultat_obs')->nullable()->after('resultat_affectation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concour_suivis', function (Blueprint $table) {
            $table->dropColumn([
                'resultat_statut',
                'resultat_date',
                'resultat_attestation',
                'resultat_affectation',
                'resultat_obs'
            ]);
        });
    }
};

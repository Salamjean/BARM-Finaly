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
        if (!Schema::hasTable('concour_suivis')) {
            Schema::create('concour_suivis', function (Blueprint $table) {
                $table->id();
                $table->foreignId('candidature_id')->constrained('candidatures')->cascadeOnDelete();
                
                // Step 1 : Choix du concours
                $table->date('date_choix')->nullable();
                $table->string('intitule_concours')->nullable();
                $table->string('type_concours')->nullable();
                
                // Step 2 : Prépa concours
                $table->date('prepa_date_debut')->nullable();
                $table->date('prepa_date_fin')->nullable();
                $table->string('prepa_statut')->nullable(); // 'present', 'absent', 'abandon'
                $table->text('prepa_obs')->nullable();
                
                // Step 3 : Prépa de dossier (2 rencontres)
                $table->date('dossier_r1_date')->nullable();
                $table->string('dossier_r1_statut')->nullable();
                $table->text('dossier_r1_obs')->nullable();
                
                $table->date('dossier_r2_date')->nullable();
                $table->string('dossier_r2_statut')->nullable();
                $table->text('dossier_r2_obs')->nullable();
                
                // Step 4 : Choix final
                $table->string('choix_final_statut')->nullable(); // 'depose', 'non_depose'
                $table->date('choix_final_date')->nullable();
                $table->string('choix_final_recu')->nullable();
                $table->text('choix_final_motif')->nullable();
                
                $table->foreignId('autor_id')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concour_suivis');
    }
};

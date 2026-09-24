<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('concour_suivis') && Schema::hasTable('candidatures')) {
            // 1. Synchroniser tous les candidats orientés Fonction Publique
            $candidatsFP = DB::table('candidatures')
                ->where('orientation', 'fonction-publique')
                ->get();

            foreach ($candidatsFP as $cand) {
                // Vérifier s'il a déjà un enregistrement dans concour_suivis
                $existing = DB::table('concour_suivis')->where('candidature_id', $cand->id)->first();

                // Récupérer inscription existante si disponible
                $inscription = Schema::hasTable('inscriptionconcours')
                    ? DB::table('inscriptionconcours')->where('candidature_id', $cand->id)->first()
                    : null;

                // Récupérer soumission dossier existante si disponible
                $soumission = Schema::hasTable('soumissiondossiers')
                    ? DB::table('soumissiondossiers')->where('candidature_id', $cand->id)->first()
                    : null;

                $intitule = $inscription ? $inscription->intitule_concours : ($soumission ? $soumission->intitule_concours1 : null);
                $type = $inscription ? $inscription->type_concours : ($soumission ? $soumission->type_concours1 : null);
                
                $isAdmis = ($cand->admissionconcours == '1' || $cand->admissionconcours == 1);
                $affectation = !empty($cand->affectation) ? $cand->affectation : null;

                $data = [
                    'candidature_id' => $cand->id,
                    'intitule_concours' => $existing && $existing->intitule_concours ? $existing->intitule_concours : $intitule,
                    'type_concours' => $existing && $existing->type_concours ? $existing->type_concours : $type,
                    'choix_final_statut' => ($inscription || $isAdmis || ($existing && $existing->choix_final_statut === 'depose')) ? 'depose' : ($existing ? $existing->choix_final_statut : null),
                    'choix_final_date' => $inscription ? $inscription->date : ($existing ? $existing->choix_final_date : null),
                    'choix_final_recu' => $inscription ? $inscription->recu : ($existing ? $existing->choix_final_recu : null),
                    'resultat_statut' => $isAdmis ? 'admis' : ($existing ? $existing->resultat_statut : null),
                    'resultat_affectation' => $affectation ?: ($existing ? $existing->resultat_affectation : null),
                    'autor_id' => $inscription ? $inscription->autor_id : ($cand->created_by ?? null),
                    'updated_at' => now(),
                ];

                if ($existing) {
                    DB::table('concour_suivis')->where('id', $existing->id)->update(array_filter($data, function ($val) {
                        return !is_null($val);
                    }));
                } else if ($intitule || $isAdmis || $inscription || $soumission) {
                    $data['created_at'] = now();
                    DB::table('concour_suivis')->insert($data);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Pas de suppression destructive nécessaire
    }
};

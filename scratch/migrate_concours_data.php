<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Fetch choixconcours
$choixList = DB::table('choixconcours')->get();
foreach ($choixList as $c) {
    $exists = DB::table('concour_suivis')->where('candidature_id', $c->candidature_id)->first();
    if (!$exists) {
        DB::table('concour_suivis')->insert([
            'candidature_id' => $c->candidature_id,
            'date_choix' => $c->created_at ? date('Y-m-d', strtotime($c->created_at)) : now()->toDateString(),
            'intitule_concours' => $c->intitule_concours,
            'type_concours' => $c->type_concours,
            'autor_id' => $c->autor_id,
            'created_at' => $c->created_at ?? now(),
            'updated_at' => $c->updated_at ?? now(),
        ]);
    }
}

// Fetch soumissiondossiers
$soumissions = DB::table('soumissiondossiers')->get();
foreach ($soumissions as $s) {
    $suivi = DB::table('concour_suivis')->where('candidature_id', $s->candidature_id)->first();
    if (!$suivi) {
        DB::table('concour_suivis')->insert([
            'candidature_id' => $s->candidature_id,
            'date_choix' => $s->date1,
            'intitule_concours' => $s->intitule_concours1,
            'type_concours' => $s->type_concours1,
            'dossier_r1_date' => $s->date1,
            'dossier_r1_statut' => 'Effectuée',
            'dossier_r2_date' => $s->date2,
            'dossier_r2_statut' => 'Effectuée',
            'autor_id' => $s->autor_id,
            'created_at' => $s->created_at ?? now(),
            'updated_at' => $s->updated_at ?? now(),
        ]);
    } else {
        DB::table('concour_suivis')->where('candidature_id', $s->candidature_id)->update([
            'dossier_r1_date' => $s->date1,
            'dossier_r1_statut' => 'Effectuée',
            'dossier_r2_date' => $s->date2,
            'dossier_r2_statut' => 'Effectuée',
        ]);
    }
}

// Fetch inscriptionconcours
$inscriptions = DB::table('inscriptionconcours')->get();
foreach ($inscriptions as $insc) {
    $suivi = DB::table('concour_suivis')->where('candidature_id', $insc->candidature_id)->first();
    if (!$suivi) {
        DB::table('concour_suivis')->insert([
            'candidature_id' => $insc->candidature_id,
            'date_choix' => $insc->date,
            'intitule_concours' => $insc->intitule_concours,
            'type_concours' => $insc->type_concours,
            'choix_final_statut' => 'depose',
            'choix_final_date' => $insc->date,
            'choix_final_recu' => $insc->recu,
            'autor_id' => $insc->autor_id,
            'created_at' => $insc->created_at ?? now(),
            'updated_at' => $insc->updated_at ?? now(),
        ]);
    } else {
        DB::table('concour_suivis')->where('candidature_id', $insc->candidature_id)->update([
            'choix_final_statut' => 'depose',
            'choix_final_date' => $insc->date,
            'choix_final_recu' => $insc->recu,
        ]);
    }
}

echo "Migrated " . DB::table('concour_suivis')->count() . " records to concour_suivis.\n";

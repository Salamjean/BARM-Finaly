<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\ConcoursController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Candidature;
use App\Models\ConcourSuivi;
use Illuminate\Support\Facades\Auth;

$admin = User::first();
Auth::login($admin);

$candidat = Candidature::where('orientation', 'fonction-publique')->first();
if (!$candidat) {
    echo "No FP candidat found.\n";
    exit;
}

$controller = new ConcoursController();

echo "Testing storeChoix...\n";
$reqChoix = Request::create('/concours/choix/store', 'POST', [
    'candidature_id' => $candidat->id,
    'date_choix' => '2026-09-25',
    'intitule_concours' => "AGENT D'ENCADREMENT DES ETABLISSEMENTS PENITENTIAIRES",
    'type_concours' => 'Concours Direct',
]);
$resChoix = $controller->storeChoix($reqChoix);
echo "storeChoix result status: " . $resChoix->getStatusCode() . "\n";

$suivi = ConcourSuivi::where('candidature_id', $candidat->id)->first();
echo "Suivi ID: " . $suivi->id . ", intitule: " . $suivi->intitule_concours . "\n";

echo "Testing storePrepa...\n";
$reqPrepa = Request::create('/concours/prepa/store', 'POST', [
    'suivi_id' => $suivi->id,
    'prepa_date_debut' => '2026-09-26',
    'prepa_date_fin' => '2026-10-10',
    'prepa_statut' => 'present',
    'prepa_obs' => 'Très assidu et motivé',
]);
$resPrepa = $controller->storePrepa($reqPrepa);
echo "storePrepa result status: " . $resPrepa->getStatusCode() . "\n";

echo "Testing storeDossier...\n";
$reqDossier = Request::create('/concours/dossier/store', 'POST', [
    'suivi_id' => $suivi->id,
    'dossier_r1_date' => '2026-10-12',
    'dossier_r1_statut' => 'Effectuée',
    'dossier_r1_obs' => 'Dossier vérifié, manque extrait',
    'dossier_r2_date' => '2026-10-15',
    'dossier_r2_statut' => 'Dossier conforme / Validé',
    'dossier_r2_obs' => 'Extrait fourni, dossier complet prêt au dépôt',
]);
$resDossier = $controller->storeDossier($reqDossier);
echo "storeDossier result status: " . $resDossier->getStatusCode() . "\n";

echo "Testing storeFinal...\n";
$reqFinal = Request::create('/concours/final/store', 'POST', [
    'suivi_id' => $suivi->id,
    'choix_final_statut' => 'depose',
    'choix_final_date' => '2026-10-18',
    'choix_final_motif' => 'Dossier déposé avec succès à la Fonction Publique',
]);
$resFinal = $controller->storeFinal($reqFinal);
echo "storeFinal result status: " . $resFinal->getStatusCode() . "\n";

$suivi->refresh();
echo "Final state check:\n";
echo "Choix: {$suivi->intitule_concours} ({$suivi->date_choix->format('Y-m-d')})\n";
echo "Prepa: {$suivi->prepa_statut} ({$suivi->prepa_date_debut->format('Y-m-d')} -> {$suivi->prepa_date_fin->format('Y-m-d')})\n";
echo "Dossier R1: {$suivi->dossier_r1_date->format('Y-m-d')}, R2: {$suivi->dossier_r2_date->format('Y-m-d')}\n";
echo "Final: {$suivi->choix_final_statut} ({$suivi->choix_final_date->format('Y-m-d')})\n";
echo "TEST COMPLETE SUCCESS!\n";

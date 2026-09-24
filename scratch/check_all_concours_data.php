<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== CHOIX CONCOURS ===\n";
print_r(DB::table('choixconcours')->get()->toArray());

echo "=== INSCRIPTION CONCOURS ===\n";
print_r(DB::table('inscriptionconcours')->get()->toArray());

echo "=== SOUMISSION DOSSIERS ===\n";
print_r(DB::table('soumissiondossiers')->get()->toArray());

echo "=== INTITULE CONCOURS ===\n";
print_r(DB::table('intituleconcours')->get()->toArray());

echo "=== TYPE CONCOURS ===\n";
print_r(DB::table('typeconcours')->get()->toArray());

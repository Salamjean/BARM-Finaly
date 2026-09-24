<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$tables = ['choixconcours', 'inscriptionconcours', 'soumissiondossiers', 'intituleconcours', 'typeconcours', 'concours', 'prepa_concours', 'prepa_dossiers'];
foreach ($tables as $t) {
    if (Schema::hasTable($t)) {
        echo "Table: {$t}\n";
        print_r(Schema::getColumnListing($t));
        $count = DB::table($t)->count();
        echo "Count: {$count}\n";
        $first = DB::table($t)->first();
        if ($first) {
            print_r($first);
        }
    } else {
        echo "Table: {$t} (NOT FOUND)\n";
    }
}

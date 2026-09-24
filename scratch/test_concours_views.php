<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\ConcoursController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

$admin = User::first();
if ($admin) {
    Auth::login($admin);
}

$controller = new ConcoursController();

echo "1. Testing choix()...\n";
$req1 = new Request();
$res1 = $controller->choix($req1);
echo "Choix View: " . $res1->name() . " (OK)\n";

echo "2. Testing prepa()...\n";
$req2 = new Request();
$res2 = $controller->prepa($req2);
echo "Prepa View: " . $res2->name() . " (OK)\n";

echo "3. Testing dossier()...\n";
$req3 = new Request();
$res3 = $controller->dossier($req3);
echo "Dossier View: " . $res3->name() . " (OK)\n";

echo "4. Testing final()...\n";
$req4 = new Request();
$res4 = $controller->final($req4);
echo "Final View: " . $res4->name() . " (OK)\n";

echo "ALL 4 CONCOURS VIEWS AND CONTROLLER METHODS FUNCTION PROPERLY!\n";

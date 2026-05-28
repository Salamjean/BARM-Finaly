<?php

use App\Http\Controllers\DuplicatCandidatureController;
use App\Http\Controllers\ExcelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Rmunate\Utilities\SpellNumber;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('village', [ExcelController::class, 'import_vilage']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('test', function(){
    dd(SpellNumber::value(675)->locale('fr')->toLetters());
});

Route::post('duplicate-candidature', [DuplicatCandidatureController::class, 'store'])->name('duplicate');

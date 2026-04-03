<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollingUnitController;

Route::prefix('polling')->group(function () {
    
    // QUESTION 1: Display individual polling unit result
    Route::get('unit/{polling_unit_id}', [PollingUnitController::class, 'showPollingUnitResult'])
        ->name('polling-unit.show');

    // QUESTION 2: Display LGA results
    Route::get('lga-results', [PollingUnitController::class, 'showLGAResults'])
        ->name('polling-unit.lga-results');

    // QUESTION 3: Create and store new polling unit results
    Route::get('create', [PollingUnitController::class, 'createPollingUnit'])
        ->name('polling-unit.create');
    
    Route::post('store', [PollingUnitController::class, 'storePollingUnitResults'])
        ->name('polling-unit.store');

    // AJAX endpoint for getting wards by LGA
    Route::get('wards/{lga_id}', [PollingUnitController::class, 'getWardsByLGA'])
        ->name('polling-unit.wards');
});

Route::get('/', function () {
    return view('welcome');
});